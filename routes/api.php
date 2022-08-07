<?php

Route::group(['prefix' => '/v1', 'middleware' => ['auth:api'], 'namespace' => 'Api\V1', 'as' => 'api.'], function () {
    Route::post('change-password', 'ChangePasswordController@changePassword')->name('auth.change_password');
    Route::get('category/type/{id}', 'CategoriesController@getTestType');
    Route::get('getInitialData', 'CategoriesController@getInitialData');
    Route::get('getTests/{cId}', 'TestsController@getTests');
    Route::get('getFactors/{tId}', 'FactorsController@getFactors');
    Route::get('getFactorResults/{fId}', 'FactorResultsController@getFactorResults');
    Route::get('getQuestions/{tId}', 'QuestionsController@getQuestions');
    Route::get('getResults/{tId}', 'ResultsController@getResults');
    Route::get('getAnswers/{qId}', 'AnswersController@getAnswers');
    Route::get('getTopicQuestions/{tqId}', 'TopicQuestionsController@getTopicQuestions');
    Route::get('tests/{id}/page', 'TestsController@getPageInfo');



    Route::apiResource('rules', 'RulesController', ['only' => ['index']]);
    Route::apiResource('categories', 'CategoriesController');
    Route::apiResource('languages', 'LanguagesController');
    Route::apiResource('tests', 'TestsController');

    Route::apiResource('factors', 'FactorsController');
    Route::apiResource('factorResults', 'FactorResultsController');
    Route::apiResource('questions', 'QuestionsController');
    Route::apiResource('topicQuestions', 'TopicQuestionsController');
    Route::apiResource('topics', 'TopicsController');
    Route::apiResource('results', 'ResultsController');
    Route::apiResource('answers', 'AnswersController');

    Route::apiResource('permissions', 'PermissionsController');
    Route::apiResource('roles', 'RolesController');
    Route::apiResource('users', 'UsersController');
});

Route::group(['prefix' => '/v2', 'namespace' => 'Api\V2', 'as' => 'api.'], function () {
    Route::get('tests', 'ForUserController@getAllTests');
    Route::get('getTests/{cId}', 'ForUserController@getTests');
    Route::get('tests/{id}', 'ForUserController@getTest');
    Route::get('tests/data/{id}', 'ForUserController@getFullTestData');
    Route::post('uploadResult', 'ForUserController@saveTestResult');
    Route::get('order/{token}', 'ForUserController@getOrder');
    Route::post('order/stripe/post', 'ForUserController@stripePost');
    Route::get('test/{token}/download/extra_test', 'ForUserController@getDownloadFile');
    Route::get('test/{token}/download/certification', 'ForUserController@getCertificationFile');
    Route::get('test/{token}/result', 'ForUserController@getResultData');
    Route::get('test/{token}/type', 'ForUserController@getTestType');
});