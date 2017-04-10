<?php

namespace App\Http\Controllers;

use App\dto\Operate;
use App\Service\Imploment\mailService;
use App\Service\Imploment\VerifyService;
use Illuminate\Http\Request;

use App\Http\Requests;

class MailController extends Controller
{
    /**
     * mailController constructor.
     */
    public function __construct()
    {
    }

    //发送验证码
    public function verifySend(Request $request)
    {
        $email = $request->input('email');
        $verify = substr(md5('0ni5USXyMXmAELTAI7WdJEmRKpSBuu43X2H5OgUDXqrIEm' . time()), 0, 6);
        $mail = new mailService($email, $verify);
        if ($mail->chechEmail($email)) {
        if ($mail->send()) {
            $ve = new VerifyService($verify, $email);
            if ($ve->saveVerify()) {
                return json_encode(new Operate(true, 'success', 0, $ve));
            }
        } else {
            return json_encode(new Operate(false, 'send email false', 0, null));
        }
    }else{
            return json_encode(new Operate(false, 'email repeated', 0, null));
        }
    }
}
