
(function(){
    this.CivicApp = this.CivicApp || {};
    this.CivicApp.Auth = this.CivicApp.Auth || {};
    this.CivicApp.Auth.CreateUser = this.CivicApp.Auth.CreateUser || {};
}());




CivicApp.Auth.CreateUser.roles = [];
CivicApp.Auth.CreateUser.grillaRoles = null;

CivicApp.Auth.CreateUser.AddRoleToList = function()
{
    var roleId = $('#selectRole').val();
    var rolName = $('#selectRole option:selected').text();

    CivicApp.Auth.CreateUser.grillaRoles.agregarItem({id:roleId, role_name:rolName});

    $('#hdnRoles').val(JSON.stringify(CivicApp.Auth.CreateUser.grillaRoles.get()));

}
/*
CivicApp.Auth.CreateUser.ValidateRoles = function(roleId)
 {
     if( CivicApp.Auth.CreateUser.roles.find( function(element){
         return roleId === element.id;
     } ))
     {
        alert('El usuario ya tiene ese rol asignado');
         return false;
     }

 }


CivicApp.Auth.CreateUser.deleteRol= function(ev)
{
    $(this).closest('tr').remove();

    var id = this.id.split('_')[1];

    for (var i=0;i < CivicApp.Auth.CreateUser.roles.length; i++) {
        if(CivicApp.Auth.CreateUser.roles[i].id == id)
        {
            CivicApp.Auth.CreateUser.roles.splice(i,1);
            break;
        }
    }

}
*/


CivicApp.Auth.CreateUser.setEventHandler = function()
{
    $('#btnAddRole').click(CivicApp.Auth.CreateUser.AddRoleToList);


}


 $(document).ready(function(){

    CivicApp.Auth.CreateUser.grillaRoles =
            new Utilities.GrillaSimple('tbRole', CivicApp.Auth.CreateUser.roles,true,true,"No se han cargado roles");

    CivicApp.Auth.CreateUser.setEventHandler();

});

