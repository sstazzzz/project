<?php
require_once ("../Services/config.php");
ini_set('display_errors', 'On');
error_reporting(E_ALL);

ini_set('error_log', ROOT_PATH."logs/error.log");

error_log('Dp request');

$request = $_REQUEST["Data"];
$request = json_decode($request);
error_log(print_r($request, true));

$result = "Ошибка обращения";
$statusCode = 400;

if (property_exists($request, 'Function'))
{
    $function = $request->Function;
    error_log($function);
    
    if ($function == "RegisterUser")
    {
        require_once ("../Services/user.php");
        $result = new CAuthUser();
        $result = $result->registration($request->Data->Login, $request->Data->Password);
        if ($result === true)
        {
            $result = "Пользователь успешно зарегистрирован!";
            $statusCode = 200;
        }
    }
    else if ($function == "Authorization")
    {
        require_once("../Services/user.php");
        $result = new CAuthUser();
        $result = $result->authorization($request->Data->Login, $request->Data->Password);
        if ($result === true)
        {
            $result = "Вы вошли в базу!";
            $statusCode = 200;
        }
    }
    else if ($function == "GetGoods") {
        $statusCode = 200;
        require_once("../Services/module.php");
        $result = new InDataBase();
        $result = $result->GetGoods();
    }
    else if ($function == "GetGoodsid") {
        $statusCode = 200;
        require_once("../Services/module.php");
        $result = new InDataBase();
        $result = $result->GetGoodsid($request->Data->id);
    }
else if ($function == "GetGoodsCategory") {
        $statusCode = 200;
        require_once("../Services/module.php");
        $result = new InDataBase();
        $result = $result->GetGoodsCategory($request->Data->Href);
    }
    else if ($function == "Page"){
            $statusCode = 200;
            require_once ("../Services/module.php");
            $result = new InDataBase();
            $result = $result->Page();
        }
else if ($function == "Pagination"){
            $statusCode = 200;
            require_once ("../Services/module.php");
            $result = new InDataBase();
            $result = $result->Pagination();
        }

    else if ($function == "GetCategory"){
        $statusCode = 200;
        require_once ("../Services/module.php");
        $result = new InDataBase();
        $result = $result->GetCategory();
    }
    else if ($function == "SearchSite"){
        $statusCode = 200;
        require_once ("../Services/module.php");
        $result = new InDataBase();
        $result = $result->SearchSite($request->Data->searchname,$request->Data->slider,$request->Data->sliderTo);
    }
}

$response = new \stdClass();
$response->StatusCode = $statusCode;
$response->Data = $result;

error_log(print_r($response, true));

$response = $_REQUEST["callback"] . "(" . json_encode($response) . ")";

echo $response;