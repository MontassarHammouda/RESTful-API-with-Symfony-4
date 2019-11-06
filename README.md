# RESTful-API-with-Symfony-4


bin/console debug:router
 ---------------------- -------- -------- ------ -------------------------- 
  Name                   Method   Scheme   Host   Path                      
 ---------------------- -------- -------- ------ -------------------------- 
  _twig_error_test       ANY      ANY      ANY    /_error/{code}.{_format}  
  app_price_getprices    GET      ANY      ANY    /places/{id}/prices       
  app_price_postprices   POST     ANY      ANY    /places/{id}/prices       
  post_place             POST     ANY      ANY    /places                   
  get_places             GET      ANY      ANY    /places                   
  get_place              GET      ANY      ANY    /places/{placeId}         
  delete_place           DELETE   ANY      ANY    /places/{placeId}         
  put_place              PUT      ANY      ANY    /places/{id}              
  patch_place            PATCH    ANY      ANY    /places/{id}              
  post_users             POST     ANY      ANY    /users                    
  get_users              GET      ANY      ANY    /users                    
  get_user               GET      ANY      ANY    /users/{UserId}           
  delete_user            DELETE   ANY      ANY    /users/{UserId}           
  patch_user             PATCH    ANY      ANY    /users/{id}               
  put_user               PUT      ANY      ANY    /users/{id}               
 ---------------------- -------- -------- ------ -------------------------- 
