<?php

namespace API\Controllers\Login;

use API\Lib\{Auth, Controller, RememberMe};
use API\Lib\Exceptions\GeneralException;
use API\Models\User\UserQuery;
use Propel\Runtime\Propel;
use Respect\Validation\Validator;
use Slim\App;

class Login extends Controller
{    
    protected $o_auth;
    protected $str_privateKey;
    
    public function __construct(App $o_app) {
        parent::__construct($o_app);
        
        $o_app->getContainer()['db'];
        
        $this->o_auth = new Auth(new UserQuery());
        $this->str_privateKey = $this->o_app->getContainer()['settings']['Auth']['RememberMe_PrivateKey'];
    }
    
    protected function POST() : void {        
        $a_validators = array(
            'username' => Validator::alnum()->noWhitespace()->length(1),
            'password' => Validator::alnum()->noWhitespace()->length(1),
            'rememberMe' => Validator::boolType()
        );
        
        $this->validate($a_validators);        
        
        $b_result = $this->o_auth->CheckLogin($this->a_json['username'], 
                                              $this->a_json['password']);
        
        if(!$b_result)
            throw new GeneralException("Login failed");
        
        if($this->a_json['rememberMe'])
        {
            $i_userid = $this->o_auth->GetCurrentUser()->getUserid();
            
            $o_rememberMe = new RememberMe($this->str_privateKey);            
            $str_hash = $o_rememberMe->remember($i_userid);                
            
            Propel::disableInstancePooling();
            
            UserQuery::create()->findPk($i_userid)
                               ->setAutologinHash($str_hash)
                               ->save();
            
            Propel::enableInstancePooling();

        }
        
        $this->o_response->withJson(true);
    }
    
    protected function GET() : void {
        
        if($this->o_auth->IsLoggedIn())
        {
            $this->o_response->withJson(array('username' => $this->o_auth->GetCurrentUser()->getUsername()));
            return;
        }
        
        $o_rememberMe = new RememberMe($this->str_privateKey);
        $i_userid = $o_rememberMe->parseCookie();
        
        if($i_userid !== false)
        {
            $o_user = UserQuery::create()->findPk($i_userid);
            $str_newHash = $o_rememberMe->validateHash((string)$o_user->getAutologinHash());
            
            if($str_newHash === false)
                throw new GeneralException("Autologin Failed");
                
            $o_user->setAutologinHash($str_newHash)->save();
            
            $this->o_auth->DoLogin($o_user->getUsername());
            
            $this->o_response->withJson(array('username' => $o_user->getUsername(),
                                              'rememberMe' => true));
        }
    }
    
    protected function DELETE() : void {
        $i_userid = $this->o_auth->GetCurrentUser()->getUserid();
            
        UserQuery::create()->findPk($i_userid)
                           ->setAutologinHash(null)
                           ->save();
            
        $this->o_auth->Logout();
        RememberMe::Destroy();        
    }
}