<?php

namespace Structure\Base\Controller;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Правила для валидации по которым берется дата из запроса
     *
     * @var array
     */
    protected $rules = [];

    /**
     * @var Request
     */
    protected $request;

    /**
     * Вернуть завалидированную разрешенную дату из запроса
     *
     * @return array|null
     * @throws \Exception
     */
    protected function getValidateData(): ?array
    {
        if (empty($this->rules)) {
            throw new \Exception("rules is empty");
        }
        if (!$this->request instanceof Request) {
            throw new \Exception("request type is not allowed");
        }

        try {
            $accessData = $this->getAccessData();
        } catch (\Exception $exception) {
            $validateErrors = $this->validate();
            $exception = $this->getValidationException($validateErrors);
            throw $exception;
        }

        return $accessData;
    }

    /**
     * Возвращение обекта ошибки в случае ошибки
     *
     * @return \Exception
     */
    protected function getValidationException(array $validateErrors): \Exception
    {
        return new \Exception("validate exception");
    }

    /**
     * Метод получения разрешенных даннхы из запроса
     *
     * @return mixed
     */
    protected function getAccessData(): array
    {
        return $this->request->validate($this->rules);
    }

    /**
     * Метод вылидации данных
     *
     * @param array $data
     * @return array
     */
    protected function validate(): array
    {
        /** @var ValidatorContract $validator */
        $validator = Validator::make($this->request->all(), $this->rules);
        return $validator->errors()->toArray();
    }
}
