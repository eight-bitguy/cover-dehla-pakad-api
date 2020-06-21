<?php

namespace App\Http\Controllers;

use App\Http\Transformers\ErrorTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $fractalManager;

    /**
     * Controller constructor.
     *
     * @param Manager $manager Fractal manager for transforming resources.
     */
    public function __construct(Manager $manager)
    {
        $this->fractalManager = $manager;
    }

    /**
     * @param Model $model
     * @param TransformerAbstract $transformer
     * @param int $status
     * @param bool $useJustDataKeyAsRoot
     * @return JsonResponse
     */
    protected function renderJson(
        Model $model,
        TransformerAbstract $transformer,
        int $status = Response::HTTP_OK,
        bool $useJustDataKeyAsRoot = false
    ) : JsonResponse
    {
        $resource          = new Item($model, $transformer);
        $resourceArray     = $this->fractalManager->createData($resource)->toArray();
        $resourceArrayData = $useJustDataKeyAsRoot ? $resourceArray['data'] : $resourceArray;

        return response()->json($resourceArrayData, $status);
    }

    /**
     * @param array $errors
     * @param int $status
     * @return JsonResponse
     */
    protected function renderErrors(array $errors, int $status): JsonResponse
    {
        $errorTransformer = new ErrorTransformer($status);
        return response()->json($errorTransformer->transform($errors));
    }

    /**
     * Serializes the collection to json response.
     *
     * @param mixed               $collection  Array of models to be serialized
     * @param TransformerAbstract $transformer Transformer used to serialize the collection
     * @param int                 $status      Http status code that is returned with response
     *
     * @return JsonResponse Json response
     */
    protected function renderJsonArray(
        $collection,
        TransformerAbstract $transformer,
        int $status = Response::HTTP_OK
    ) : JsonResponse
    {
        $collection = new Collection($collection, $transformer);
        $collection = $this->fractalManager->createData($collection)->toArray();

        return response()->json($collection, $status);
    }

    /**
     * Method to set includes
     *
     * @param array $parseIncludes array of includes
     *
     * @return void
     */
    protected function setParseIncludes(array $parseIncludes): void
    {
        $this->fractalManager->parseIncludes($parseIncludes);
    }


}
