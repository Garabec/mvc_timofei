<?php

class ContactController extends Controller{
    
    
    public function __construct($data=array()){
      
      parent::__construct($data);
      
      
      $this->model['message']=new MessageRepasitory;
      
      
      
    }
    
    
    
    
    public function sendAction(){
      
     $form=new ContactForm;
     
     
     if($form->getRequest()->isPost()){
       
        if($form->isValid()){
          
              $message=new Message;
              
                $message->setDataFromForm($form);
                
                
                
          if($this->model['message']->save($message)){
        
                Session::setFlash('Sent message');
        
        
             }else{ Session::setFlash('No sent message');};
       
       
     }else{ Session::setFlash('Fill the fields');};
         
     
     
     
     
     }
    
    }
    
    public function viewAction(){
        
      $this->data['contact']='Views ContactController->viewAction';
      
     //echo "ContactController->indexAction" ;
        
    }
    
   
   public function admin_messageAction(){
       
      //$this->data=$this->model['message']->getListMessage();
      
      if($this->params){  $params_sort=$this->params;
        
        $this->data=$this->model['message']->getListMessage($params_sort[0],$params_sort[1]);}
      
      else{$this->data=$this->model['message']->getListMessage();}; 
      
       
   }
   
   public function admin_message_deleteAction(){
       
       
       $id=$this->params;
       
        $this->data=$this->model['message']->deleteMessage($id[0]);
      
      
      App::redirect("/admin/contact/message");
       
   } 
    
}