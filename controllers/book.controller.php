<?php

class BookController extends Controller {
  
  
  public function __construct($data=array()){
    
    
    parent::__construct($data);
    
    $this->model['book']=new BookRepasitory;
    $this->model['style']=new StyleRepasitory;
    
  }
  
  
    
    
    public function indexAction(){
        
        
        
      $this->data=$this->model['book']->getListBook() ; 
      
        
    }
    
    
    public function viewAction(){
        
     $params=App::getRouters()->getParams(); 
     
     $alias=isset($params[0])?strtolower($params[0]):null;
        
      //echo 'PageController -> indexAction' ; 
        
      $this->data=$this->model['book']->getIdBook($alias); 
      
      
     
        
    }
    
    
    
   public function  admin_indexAction(){
     
     
     $this->data=$this->model['book']->getListBook() ;
     
     
   }
    
    
  public function admin_edit_form_bookAction(){
    
    $params=App::getRouters()->getParams(); 
     
     $alias=isset($params[0])?strtolower($params[0]):null;
        
      $this->data['book']=$this->model['book']->getIdBook($alias); 
      
      $this->data['style']=$this->model['style']->findAll();
    
    
  }  
    
 
 
  public function admin_edit_bookAction(){
    
    
   
    
    
    $form= new BookFormEdit;
    
  if( $form->getRequest()->isPost()){
    
    
        if($form->isValid()){
          
          $book=new Book;
         
              $book->getFromFormData($form);
              
              var_dump($book);
              die;
         
                  $this->model['book']->save($book);
                  
    
    App::redirect("/admin/book");
         
         
         
      }
     
   
     
     
     
     
  }
    
    

    
    
    
    
  } 
    
    
}