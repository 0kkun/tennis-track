<?php

// namespace App\Repositories;

// use App\Eloquents\EloquentTennisAtpRanking;
// use App\Repositories\Interfaces\TennisAtpRankingRepositoryInterface;
// use Illuminate\Support\Collection;

// class EloquentTennisAtpRankingRepository implements TennisAtpRankingRepositoryInterface
// {
//     /**
//      * @param EloquentTennisAtpRanking $tennisAtpRanking
//      */
//     public function __construct(private EloquentTennisAtpRanking $tennisAtpRanking)
//     {
//         $this->tennisAtpRanking = $tennisAtpRanking;
//     }

//     /**
//      * {@inheritDoc}
//      */
//     public function getLatestUpdatedRecord(): ?EloquentTennisAtpRanking
//     {
//         return $this->tennisAtpRanking
//             ->latest('updated_ymd')
//             ->first();
//     }

//     /**
//      * {@inheritDoc}
//      */
//     public function insert(array $params): void
//     {
//         $this->tennisAtpRanking
//             ->insert($params);
//     }

//     /**
//      * {@inheritDoc}
//      */
//     public function fetchWithPlayerByParams(?array $searchParams = []): ?Collection
//     {
//         return $this->tennisAtpRanking
//             ->with('player')
//             ->when(! empty($searchParams) && ! empty($searchParams['name']), function ($query) use ($searchParams) {
//                 $query->where('name_en', 'like', $searchParams['name'].'%');
//             })
//             ->limit(EloquentTennisAtpRanking::ITEM_PER_PAGE)
//             ->get();
//     }

//     /**
//      * {@inheritDoc}
//      */
//     public function getById(int $id): EloquentTennisAtpRanking
//     {
//         return $this->tennisAtpRanking
//             ->with('player')
//             ->find($id);
//     }
// }
