<?php



class SecurityController extends Controller {
    
    
    public function __construct($data=array()){
      
      parent::__construct($data);
      
      
      $this->model['user']=new UserRepasitory;
      
      
      
    }
    
    
    
    
public function loginAction() {
        
        $form=new LoginForm;
        
        
        if($form->getRequest()->isPost()){
            
            if($form->isValid()){
                
                $user=new User;
                
                   $user->getFromFormData($form);
                
                $result=$this->model['user']->find($user);  
                
                
                
                
         if($result) {
             
              Session::setFlash("Sign in"); 
              Session::set('user',$user->getEmail());
              
              
              
              
              if($result['role']=='admin'){
                  
                Session::set('role',$result['role']); 
                  
                App::redirect('/admin');
                  
              };
             
         } else {
             
              Session::setFlash("User not found ");   
             
         }      
                
                
         } else {
             
             
             Session::setFlash("Fill the fields ");};
            
            
        }
        
    }
    
    

public function logoutAction(){
    
    
 $this->model['user']->logout();   
    
 App::redirect('/security/login');   
    
}





 
 
 public function registerAction(){
     
     $form=new RegisterForm;
      

        
        if($form->getRequest()->isPost()){
            
            if($form->isValid()){
                
                  if($form->matchPassword()) {


                          if($form->matchCaptcha(Session::get('captcha'))) {
                     
                          $user=new User;
                
                                $user->getFromFormData($form);
                     
                    
                    
                                      if(!$this->model['user']->findNameUser($user)){
            
           
                        
                                           if($this->model['user']->addUser($user)) {Session::setFlash("User  registration  ");}
                       
                       
                            else {Session::setFlash("Error registration  ");};
                       
                       
                       
                        
                        
                        
                        
                    } else { Session::setFlash("User found . You not registration  ");    };
                    
                    
                   }  else { Session::setFlash("Characters not matchn ");    };
                     
                     
                 } else {Session::setFlash("Password not match  ");};
                
                
                
                
             
             
             
            
            
        } else {Session::setFlash("Fill the fields  ");};
        
    }
    
}
 
 
 public function admin_usersAction(){
     
     
     
    //$this->data=$this->model['user']->getListUsers() ;
     
     
   if($this->params){  $params_sort=$this->params;
        
        $this->data=$this->model['user']->getListUsers($params_sort[0],$params_sort[1]);}
      
      else{$this->data=$this->model['user']->getListUsers();};    
     
 }
    
 
 
 public function admin_edit_form_userAction(){
     
     
    $id=$this->params; 
    
    
     
    $this->data['user']=$this->model['user']->findUser($id[0]) ;
     
    
     
     
 }
 
 
 public function admin_user_save_editAction(){
    
    
   
    
    
    $form= new UserFormEdit;
    
    
    
    
  if( $form->getRequest()->isPost()){
    
    
        if($form->isValid()){
            
          
          
          $user=new User;
         
              $user->getFromFormData($form);
              
             
                       $this->model['user']->save($user);
                  
    
    
         
         
         
      }else {
          
           $user=new User;
         
           $user->getFromFormData($form);
          
          
          Session::setFlash('Fill the fields');
          
          App::redirect('/admin/security/edit_form_user/'.$user->getId());
          
          
          
          
      }
      
      
     }
     
     App::redirect("/admin/security/users");
     
    } 
 
 
 
 
 
public function admin_delete_userAction(){
       
       
       $id=$this->params;
       
      $this->data=$this->model['user']->deleteUser($id[0]);
      
      
      App::redirect("/admin/security/users");
       
   }  
 
 
 
 
    
    
}