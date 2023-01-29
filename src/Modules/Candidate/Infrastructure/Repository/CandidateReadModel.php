<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Infrastructure\Repository;

use App\Modules\Candidate\Application\ReadModel\CandidateReadModel as CandidateReadModelInterface;
use App\Modules\Candidate\Application\Search\SearchQuery;
use App\Modules\Candidate\Application\ViewModel\CandidateSkillViewModel;
use App\Modules\Candidate\Application\ViewModel\SearchedCandidateViewModel;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\Expression\CompositeExpression;
use Doctrine\DBAL\Query\QueryBuilder;

final class CandidateReadModel implements CandidateReadModelInterface
{
    private const DB_TABLE_NAME = 'candidates';
    private const DB_SKILLS_TABLE_NAME = 'skills';

    private const DB_CANDIDATES_SKILLS_TABLE_NAME = 'candidates_skills';

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function search(SearchQuery $query): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $offset = ($query->page * $query->perPage) - $query->perPage;

        $rawResults = $queryBuilder
            ->select('c.id', 'c.first_name', 'c.last_name')
            ->from(self::DB_TABLE_NAME, 'c')
            ->join('c', self::DB_CANDIDATES_SKILLS_TABLE_NAME, 'cs', 'c.id = cs.candidate_id')
            ->where(
                $this->prepareWhereAccordingQueryFilters($queryBuilder, $query)
            )
            ->setFirstResult($offset)
            ->setMaxResults($query->perPage)
            ->fetchAllAssociative();

        $candidatesIds = [];

        foreach ($rawResults as $rawResult) {
            $candidatesIds[] = '"' . $rawResult['id'] . '"';
        }

        if (!$candidatesIds) {
            return [];
        }

        $candidatesSkillsRawData = $this->connection
            ->createQueryBuilder()
            ->select('cs.skill_id', 'cs.candidate_id', 'cs.numeric_score')
            ->from(self::DB_CANDIDATES_SKILLS_TABLE_NAME, 'cs')
            ->where(
                $queryBuilder->expr()->in('cs.candidate_id', $candidatesIds)
            )
            ->fetchAllAssociativeIndexed();

        $skillsIds = [];

        foreach ($candidatesSkillsRawData as $skillId => $candidateSkillsRawData) {
            $skillsIds[$skillId] = '"' . $skillId . '"';
        }

        $skillsNames = $this->connection
            ->createQueryBuilder()
            ->select('id', 'name')
            ->from(self::DB_SKILLS_TABLE_NAME)
            ->where(
                $queryBuilder->expr()->in('id', $skillsIds)
            )
            ->fetchAllAssociativeIndexed();

        $candidates = [];
        foreach ($rawResults as $rawCandidate) {
            $candidateSkills = [];

            foreach ($candidatesSkillsRawData as $skillId => $candidateSkillRawData) {
                if ($candidateSkillRawData['candidate_id'] === $rawCandidate['id']) {
                    $candidateSkills[] = new CandidateSkillViewModel(
                        $skillId,
                        $candidateSkillRawData['candidate_id'],
                        (string) $skillsNames[$skillId]['name'],
                        $candidateSkillRawData['numeric_score']
                    );
                }
            }

            $candidates[] = new SearchedCandidateViewModel(
                $rawCandidate['id'],
                $rawCandidate['first_name'],
                $rawCandidate['last_name'],
                $candidateSkills
            );
        }

        return $candidates;
    }

    private function prepareWhereAccordingQueryFilters(
        QueryBuilder $queryBuilder,
        SearchQuery $query
    ): CompositeExpression {
        $expressions = [];

        foreach ($query->mustHaves->filters as $mustHave) {
            $skillIdQueryKey = ':' . str_replace('-', '_', $mustHave->skillId) . '_id_value';
            $skillScoreQueryKey = ':' . str_replace('-', '_', $mustHave->skillId) . '_score_value';

            $expressions[] = $queryBuilder->expr()->eq('cs.skill_id', '"' . $mustHave->skillId . '"');
            $expressions[] = $queryBuilder->expr()->gte('cs.numeric_score', $mustHave->skillScore);

            // @TODO: fix parameters bounding
            // $queryBuilder->setParameter($skillIdQueryKey, $mustHave->skillId);
            // $queryBuilder->setParameter($skillScoreQueryKey, $mustHave->skillScore);
        }

        return $queryBuilder->expr()->and(...$expressions);
    }
}
