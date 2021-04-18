# E-Commerce-CRUD


Create a module where nested categories are there and on delete of the
parent category , delete on cascade should happen.
Example :- Lets consider an E comm application , which has multi level
of products category .
Eg :- Clothing -> Mens -> sports -> t-shirt . On delete of clothing ,
(mens , sports , tshrt all 3 should get delete , if mens will get delete
then sports and t-shirt will be deleted but clothing will not . ) Give
an option to rollback the delete operation through front End
