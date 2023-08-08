<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 10.02.2020
 */

namespace Appus\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Appus\Admin\EncryptionService;
use Appus\Admin\Table\Traits\QueryableTrait;
use Illuminate\Http\Request;

class MultiActionController extends Controller
{

    use QueryableTrait;

    protected $model;
    protected $filters;
    protected $searchable;

    public function run(Request $request)
    {
        $multiAction = EncryptionService::decrypt($request->get('_id'));
        $multiAction = new $multiAction;
        $model = EncryptionService::decrypt($request->get('_key'));
        $this->model = new $model;

        $this->filters = $this->getFilters($request->get('_filters'));
        $this->searchable = $request->get('_searchable', []);

        $this->addWithQuery($request);
        $this->addIdsQuery($request);
        $query = $this->getQuery();
        $this->addPageQuery($query, $request);
        $data = $query->get();
        $responseData = $multiAction->run($data, $request->get('_selected', null));
        return response()->json([
            'success' => true,
            'reloadPageAfterAction' => $multiAction->isReloadPageAfterAction(),
            'redirectUrl' => $multiAction->getRedirectUrl(),
            'jsCallback' => $multiAction->getJsFunctionNameCallback(),
            'customData' => $responseData,
        ]);
    }

    /**
     * @param Request $request
     */
    protected function addIdsQuery(Request $request)
    {
        $ids = $request->get('ids');
        if ($ids) {
            $this->query(function ($q1) use ($ids) {
                $q1->whereIn('id', $ids);
            });
        }
    }

    /**
     * @param Request $request
     */
    protected function addWithQuery(Request $request)
    {
        $fields = $request->get('_fields');
        $relations = $this->getRelations($fields);
        if (!empty($relations)) {
            $this->with($relations);
        }
    }

    /**
     * @param $query
     * @param Request $request
     */
    protected function addPageQuery($query, Request $request)
    {
        $page = $request->get('page', 1);
        $itemPerPage = $request->get('itemPerPage', 10);
        $query->limit($itemPerPage)
            ->offset(($page - 1)*$itemPerPage);
    }

    /**
     * @param array $fields
     * @return array
     */
    protected function getRelations(array $fields): array
    {
        $res = [];
        foreach ($fields as $field) {
            $rel = explode('.', $field);
            array_pop($rel);
            if (!empty($rel)) {
                $rel = implode('.', $rel);
                $res[] = $rel;
            }
        }
        return $res;
    }

    /**
     * @param array|null $filters
     * @return array
     */
    protected function getFilters(array $filters = null): array
    {
        if (!$filters) {
            return [];
        }
        $res = [];
        foreach ($filters as $filter) {
            $filterElement = app(EncryptionService::decrypt($filter));
            $res[$filterElement->getKey()] = $filterElement;
        }
        return $res;
    }

    /**
     * @return array
     */
    protected function getSearchableColumns(): array
    {
        return $this->searchable;
    }

}
