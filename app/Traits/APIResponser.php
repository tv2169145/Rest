<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;


trait APIResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    /**   response全部 (多項目)   **/
    protected function showAll(Collection $collection, $code = 200)
    {
        if($collection->isEmpty()){
            return $this->successResponse(['data' => $collection], $code);
        }


        //取得屬於自己的transformer
        $transformer = $collection->first()->transformer;

        //過濾
        $collection = $this->filterData($collection, $transformer);

        //排序
        $collection = $this->sortData($collection, $transformer);

        //分頁
        $collection = $this->paginate($collection);

        //取得格式轉換後的資料
        $collection = $this->transformData($collection, $transformer);

        //cache
        $collection = $this->cacheResponse($collection);


        return $this->successResponse($collection, $code);
    }

    /**   response單一項    **/
    protected function showOne(Model $instance, $code = 200)
    {
        $transformer = $instance->transformer;
        $instance = $this->transformData($instance, $transformer);

        return $this->successResponse($instance, $code);
    }

    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }


    //**     filter  過濾        **/
    protected function filterData(Collection $collection, $transformer)
    {
        //url : restfulapi.test/user?sort_by=identifier&isVerified=0

        // request()->query 會輸出   [ 'sort_by' => 'identifier'
        //                            'isVerified' => '0'
        //                                                  ]

        foreach(request()->query as $query => $value){
            $attribute = $transformer::originalAttribute($query);

            if(isset($attribute, $value)){
                $collection = $collection->where($attribute, $value);
            }
        }
        return $collection;
    }


    //**      sort  排序         **/
    protected function sortData(Collection $collection, $transformer)
    {
        if(request()->has('sort_by')){

            //**  取transform裡的靜態originalAttribute方法  */
            $attribute = $transformer::originalAttribute(request()->sort_by);

            $collection = $collection->sortBy($attribute);
        }

        return $collection;
    }

    //**     分頁                 **/
    private function paginate(Collection $collection)
    {
        $rules =[
            'per_page' => 'integer|min:2|max:50',
        ];
        //因為是在trait 所以無法用$this->validate()
        Validator::validate(request()->all(), $rules);

        //當前頁
        $page = LengthAwarePaginator::resolveCurrentPage();

        //每頁幾筆
        $perPage = 15;
        if(request()->has('per_page')){
            $perPage = (int) request()->per_page;
        }

        $result = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        //   'path'為必備
        //   LengthAwarePaginator::resolveCurrentPath() 輸出為當前url
        //   ['path' => LengthAwarePaginator::resolveCurrentPath()] 輸出為 "當前url"?page=下一頁碼或上一頁碼
        $paginated = new LengthAwarePaginator($result, $collection->count(), $perPage, $page, [
           'path' =>  LengthAwarePaginator::resolveCurrentPath(),
        ]);

        //將參數帶給路徑 ex:http://restfulapi.test/user?sort_by=name&page=2 例如:過濾器參數 或 排序參數
        $paginated->appends(request()->all());

        return $paginated;
    }

    //transform 格式轉換
    protected function transformData($data, $transform)
    {
        //fractal為套件的函數
        $transformation = fractal($data, new $transform);

        return $transformation->toArray();
    }

    // cache
    private function cacheResponse($data)
    {
        //抓當前url
        $url = request()->url();
        $queryParams = request()->query();

        ksort($queryParams);

        $queryString = http_build_query($queryParams);

        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30/60, function() use ($data){
           return $data;
        });
    }

}