<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use CivicApp\DAL\Auth\UserRepository as UserRepo;
use Illuminate\Support\Collection;
use CivicApp\Entities\Auth;
use CivicApp\Entities\Auth\AppUser;
use CivicApp\Models\Auth\App_User;
use CivicApp\Entities\Auth\Role;
use CivicApp\Utilities\Mapper;
use CivicApp\Utilities\IMapper;
use CivicApp\Utilities\Enums;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    private function testBasicRepoUserCreate()
    {
        //$user = new UserRepo();
   //    $this->eloquent =  Mockery::mock('Eloquent');

        $this->assertInstanceOf('Illuminate\Container\Container', $this->app);



        $user = new UserRepo($this->app);
//        var_dump($user);


        $newUser = $user->create(['first_name'=>'nico',
                       'last_name'=>'Ortiz Olmos',
                       'email'=>'nic2o@nico.com',
                       'password' => bcrypt('password')]);

        print('newUser'.$newUser);
        $this->seeInDatabase('app_users',['last_name'=>'Ortiz']);

       // var_dump('hola');
       // $this->visit('    /')
       //      ->see('Laravel 5');
    }

    private function testBasicExample2()
    {


        $this->assertInstanceOf('Illuminate\Container\Container', $this->app);

        $user = factory(CivicApp\Models\Auth\App_User::class)->make();


        $role = (factory(CivicApp\Models\Auth\Role::class)->make());



        $userRepo = new UserRepo($this->app);


        $newUser = $userRepo->create($user->toArray());
        $newUser->roles()->save($role);
        foreach( $newUser->getAttributes() as $clave => $valor ){
            printf($clave .":".$valor."\n");

        }
        printf("\nRoles\n");

        print_r( $newUser->roles->toArray());

        var_dump($newUser->roles->toArray());

        //print('newUser'.$newUser);
        $this->seeInDatabase('app_users',['email'=>$user->email]);


    }

    private function viewAttributes()
    {

        $newUser= new \CivicApp\Models\Auth\App_User();
        foreach( $newUser->getAttributes() as $clave => $valor ){
            printf($clave .":".$valor."\n");

        }
    }

    private function createEntityUser()
    {
        $faker = Faker\Factory::create();

        $user = $this->app->make('AppUser');
        $user->username = $faker->userName;
        $user->first_name=$faker->name;
        $user->last_name =$faker->lastName;
        $user->id = 0;
        $user->email = $faker->email;
        $user->password = $faker->password(10,10);
        $user->remember_token = $faker->linuxPlatformToken;

        return $user;
    }

    private function createEntityRol()
    {
        $faker = Faker\Factory::create();

        /** @var Role $role */
        $role = $this->app->make('Role');

        $role->id =   1 ;// $faker->unique()->randomDigit;
        $role->role_name = $faker->text(10);

        return $role;
    }

    private function ContainerSimulate()
    {

        $this->app->singleton( IMapper::class ,function(){
            $mapper = $this->app->make(Mapper::class);
            $mapper->addMap('CivicApp\Entities\Auth\AppUser','CivicApp\Models\Auth\App_User', Enums\MapperConfig::toModel );
            $mapper->addCustomMap('CivicApp\Entities\Auth\AppUser','CivicApp\Models\Auth\App_User',
                function (AppUser $entityUser, App_User $modelUser){

                    printf("\nCustom:\n");

                    //var_dump($entityUser);

                    //var_dump($modelUser);

                    foreach($entityUser->roles as $role)
                    {
                        $rolModel = new \CivicApp\Models\Auth\Role();

                        var_dump($role);

                        $rolModel->id = $role->id;
                        $rolModel->role_name = $role->role_name;

                        $modelUser->roles->push($rolModel);
                    }

                    return $modelUser;

                });
           return $mapper;
        });

    }

    public function testMapperToModel()
    {

        $this->bindEntities();
        $this->ContainerSimulate();
        $user = $this->createEntityUser();


        $role = $this->createEntityRol();


        printf("\n".$user->first_name);
        printf("\n".$user->last_name);
        printf("\n".$user->fullname."\n" );


        $user->roles->push($role);


        var_dump($user);

        /** @var Mapper  $userMapper */
        $mapper = $this->app->make(IMapper::class);

       // $userMapper->addMap('CivicApp\Entities\Auth\AppUser','CivicApp\Models\Auth\App_User', Enums\MapperConfig::toModel );


        //$userMapper->setClasses('CivicApp\Entities\Auth\AppUser','CivicApp\Models\Auth\App_User');

        /** @var Eloquent $userModel */
        $userModel = $mapper->map(CivicApp\Entities\Auth\AppUser::class,CivicApp\Models\Auth\App_User::class,$user);



        $userModel->save();
        $ids = $userModel->roles->pluck('id');
        $userModel->roles()->attach($ids->all());

        var_dump($userModel);



    }

    private function bindEntities()
    {
        $this->app->bind('AppUser',function()
        {
            return new AppUser(new Collection());
        });

        $this->app->bind('Role',function()
        {
            return new Role(new Collection());
        });

       /* $this->app->bind('Mapper',function()
        {
            return new Mapper($this->app);
        });*/




    }

    private  function  testGetterSettersEntity()
    {
        $newUser= CivicApp\Models\Auth\App_User::find(5);

        //var_dump($newUser);

        $newUser = new \CivicApp\Models\Auth\App_User();

        $newUser->first_name= "nico";
        $newUser->last_name = "ortizolmos";
        $newUser->email = "n2n226n2n2@nndn.com";

        $role = \CivicApp\Models\Auth\Role::find(7);


        DB::beginTransaction();

        $newUser->save();

        $newUser->password='324525';

        $newUser->save();

        $newUser->roles()->attach($role);
  //        $newUser->roles()->add($role);

        //$newUser->save();

        DB::commit();

        print_r($newUser->toArray());

        foreach( $newUser->getAttributes() as $clave => $valor ){
            printf($clave .":".$valor."\n");

        }

        foreach( $newUser->roles as $role ){
            foreach( $role->getAttributes() as $clave => $valor ){
                printf($clave .":".$valor."\n");

            }

        }


        $this->app->bind('AppUser',function()
        {
            return new AppUser(new Collection());
        });

        $this->app->bind('Role',function()
        {
            return new Role(new Collection());
        });

        $user = $this->app->make('AppUser');

        $user->first_name='Nico';
        $user->last_name ="Ortiz Olmos";

        printf("\n".$user->first_name);
        printf("\n".$user->last_name);
        printf("\n".$user->fullname."\n" );

        $rol= $this->app->make('Role');
        $rol->role_name= 'Admin';

        //var_dump($user);

        $user->roles->push($rol);

        $rol= $this->app->make('Role');
        $rol->role_name= 'OnlyReader';

        //var_dump($user);

        $user->roles->push($rol);

        foreach($user->roles as $role)
        {
            /** @var CivicApp\Entities\Auth\Role $role */
            printf("\n".$role->id);
            printf("\n".$role->role_name);

        }




      //  print_r($user->roles);




    }

  /*  public function asociateRolToUser()
    {
        //$user = new UserRepo();
        //    $this->eloquent =  Mockery::mock('Eloquent');

        $this->assertInstanceOf('Illuminate\Container\Container', $this->app);

        $user = factory(CivicApp\Models\Auth\App_User::class)->make();

//        var_dump($user);
        //->each(function($u) {
        //    $u->roles()->save(factory(CivicApp\Models\Auth\Role::class)->make());});
        $role = (factory(CivicApp\Models\Auth\Role::class)->make());

        //      var_dump($role);
        // $user->roles()->save($role);

        $userRepo = new UserRepo($this->app);
//        var_dump($user);


        $newUser = $userRepo->create($user->toArray());

        $newUser->roles()->save($role);

        print('newUser'.$newUser);
        $this->seeInDatabase('app_users',['email'=>$user->email]);


    }*/
}
