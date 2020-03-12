// pruebadrupal js

jQuery( document ).ready(function() {
    jQuery('#myModal').modal('toggle')
});

jQuery("#edit-submit").on("click", function()
   {
    /* Validar el formulario */
    jQuery("#registrousuario-form").validate
         ({
             rules: 
             {
               usuario: {
               	required: true,
               	minlength: 2, 
               	maxlength: 50
               },
               correo: {
               	required: true,
      			step: 10,
      			email: true,
               },

               

             },
             messages: 
             {
               usuario: {
               	required: 'El campo es requerido', 
               	minlength: 'El mínimo permitido son 2 caracteres', 
               	maxlength: 'El máximo permitido son 50 caracteres'
               },
               correo: 'El campo correo no es correcto y es requerido',
             }
         });
 });


jQuery(document).ready(function() {
    jQuery('#listausuarios').DataTable();
} );