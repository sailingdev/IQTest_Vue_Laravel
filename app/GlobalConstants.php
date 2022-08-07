<?php

namespace App;

class GlobalConstants
{
    const EXAM_TEST_TYPE                =   1;
    const SINGLE_FACTOR_TEST_TYPE       =   2;
    const MULTI_FACTOR_TEST_TYPE        =   3;
    const MAX_FACTOR_RESULT_CNT         =   4;
    const CERTIFICATION_FILE_PATH       =   '/uploads/certifications/';
    const EXTRA_PDF_FILE_PATH           =   '/uploads/extraPDF/';
    const CERTIFICATION_BACK_IMG_PATH   =   '/uploads/images/test/certificBack/';
    const CERTIFICATION_LOGO_IMG_PATH   =   '/uploads/images/test/certificLogo/';
    const EVALUATION_LOGO_IMG_PATH      =   '/uploads/images/test/evaluationLogo/';
    const EXTRA_LOGO_IMG_PATH           =   '/uploads/images/test/extraLogo/';
    const ANSER_IMG_PATH                =   '/uploads/images/answer/';
    const QUESTION_IMG_PATH             =   '/uploads/images/question/';
    const FACTOR_IMG_PATH               =   '/uploads/images/factor/';
    const FACTOR_RESULT_IMG_PATH        =   '/uploads/images/factorResult/';
    const RESULT_IMG_PATH               =   '/uploads/images/result/';

    public static function saveBase64Image($path, $image)
    {
        $ext = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        $ext = explode('+', $ext)[0];
        $name = time() . '.' . $ext;

        $url = public_path($path) . $name;

        $header = substr($image, 0, strpos($image, ',') + 1);
        $image = str_replace($header, '', $image);
        $image = str_replace(' ', '+', $image);

        file_put_contents($url, base64_decode($image));

        return $path . $name;
    }
}