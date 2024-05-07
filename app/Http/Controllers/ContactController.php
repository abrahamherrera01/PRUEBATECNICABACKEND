<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Phone;


class ContactController extends Controller
{

    public function index(){
        $contact = Contact::paginate( 10 );
        $data = array (
            'code' => 200,
            'status' => 'success',
            'contacts' => $contact
        );

        return response()->json($data, $data['code']);
    }

    public function store(Request $request){
  
        //verificacion de datos que este lleno 
        if (is_array($request->all())){
            //especificacion de tipado y campos requeridos 
            $rules = [
                'name' => 'max:255|string|required',   
                'lastname' => 'max:255|string|required', 
             ];

            try{
                //validacion de tipado y campos requeridos 
                $validator = \Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    //existio un error en los campos enviados 
                    $data = array(
                        'status' => 'error',
                        'code'   => '200',
                        'errors'  => $validator->errors()->all()
                    );
                }else{              
                    $contact = new Contact();
                    $contact->name = $request->name;            
                    $contact->lastname = $request->lastname;            
                    $contact->save(); 
                    $data = array(
                        'status' => 'success',
                        'code'   => '200',
                        'message' => 'registro creado exitosamente',
                        'contact' => $contact
                    );                
                }

            }catch (Exception $e){
                $data = array(
                    'status' => 'error',
                    'code'   => '200',
                    'message' => 'Los datos enviados no son correctos, ' . $e
                );
            }   
            
        }else{
            $data = array(
                'status' => 'error',
                'code'   => '200',
                'message'  => "error al insertar datos"
            );
        }
        return response()->json($data, $data['code']);
    }

    public function update(Request $request, $id){
 
        if ( is_array($request->all())  ){
            $rules = [
                'name' => 'max:255|string|required',   
                'lastname' => 'max:255|string|required',  
            ];

            try {
                 $validator = \Validator::make($request->all(), $rules);

                if ($validator->fails()){
                    // error en los datos ingresados
                    $data = array(
                     'status' => 'error',
                     'code'   => '200',
                     'errors'  => $validator->errors()->all()
                    );
                }else{            
                        $contact = Contact::find( $id );

 
                    if( is_object($contact) && !empty($contact)){                
                        $contact->name = $request->name;            
                        $contact->lastname = $request->lastname; 
                        $contact->save(); 

                        $data = array(
                         'status' => 'success',
                         'code'   => '200',
                         'message' => 'registro actualizado correctamente',
                         'contact' => $contact
                
                        );
                    }else{
                        $data = array(
                         'status' => 'error',
                         'code'   => '200',
                         'message' => 'id no existe'
                        );
                    }            
                }
            }catch (Exception $e){
                $data = array(
                 'status' => 'error',
                 'code'   => '200',
                 'message' => 'Los datos enviados no son correctos, ' . $e
                );
            }       

        }else{
            $data = array(
                'status' => 'error',
                'code'   => '200',
                'message' => 'datos vacios'
            );
        }
        
        return response()->json($data, $data['code']);    
    }

    public function destroy(Request $request, $id){

        if( is_array($request->all())  ){
            // Inicio Try catch
            try {
                $contact = Contact::find( $id );

                if( is_object($contact) && !is_null($contact) ){
                    try {
                        $contact->delete();

                        $data = array(
                            'status' => 'success',
                            'code'   => '200',
                            'message' => 'registro eliminado correctamente'
                        );

                    }catch (\Illuminate\Database\QueryException $e){
                     //throw $th;
                        $data = array(
                            'status' => 'error',
                            'code'   => '400',
                            'message' => $e->getMessage()
                        );
                    }

                }else{
                    $data = array(
                        'status' => 'error',
                        'code'   => '404',
                        'message' => 'El id no existe'
                    );
                }

            }catch (Exception $e){
                $data = array(
                    'status' => 'error',
                    'code'   => '404',
                    'message' => 'Los datos enviados no son correctos, ' . $e
                );
            }

        }else{
            $data = array(
                'status' => 'error',
                'code'   => '404',
                'message' => 'Los datos enviados no son correctos'
            );
        }

        return response()->json($data, $data['code']);
    }
    

    public function getContacts(){
        $contact = Contact::
        with('emails','phones','address')->get();

        $data = array (
            'code' => 200,
            'status' => 'success',
            'data' => $contact
        );

        return response()->json($data, $data['code']);

    }

    public function getContactsbyId($contact_id){
        $contact = Contact::where('id',$contact_id)->
        with('emails','phones','address')->get();

        $data = array (
            'code' => 200,
            'status' => 'success',
            'data' => $contact
        );

        return response()->json($data, $data['code']);

    }


    public function createContact(Request $request){
        //verificacion de datos que este lleno 
        if (is_array($request->all())){
            //especificacion de tipado y campos requeridos 
            $rules = [
                'name' => 'max:255|string|required',   
                'lastname' => 'max:255|string', 
                'phone'  => 'max:12|string', 
                'email'  => 'max:100|string', 
                'address'  => 'max:250|string', 
                ];

            try{
                //validacion de tipado y campos requeridos 
                $validator = \Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    //existio un error en los campos enviados 
                    $data = array(
                        'status' => 'error',
                        'code'   => '200',
                        'errors'  => $validator->errors()->all()
                    );
                }else{              
                    $contact = new Contact();
                    $contact->name = $request->name;            
                    $contact->lastname = $request->lastname;            
                    $contact->save(); 

             
                    $contact_id =$contact->id;
 
                    if(!empty($request->phone)){   
 
                        $phone = new Phone();
                        $phone->phone = $request->phone;  
                        $phone->contact_id = $request->$contact_id; 
                        $phone->save();           

                    }



                    $data = array(
                        'status' => 'success',
                        'code'   => '200',
                        'message' => 'registro creado exitosamente',
                        'contact' => $contact
                    );                
                }

            }catch (Exception $e){
                $data = array(
                    'status' => 'error',
                    'code'   => '200',
                    'message' => 'Los datos enviados no son correctos, ' . $e
                );
            }   
            
        }else{
            $data = array(
                'status' => 'error',
                'code'   => '200',
                'message'  => "error al insertar datos"
            );
        }
        return response()->json($data, $data['code']);  

    }
}
