<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;


class AddressController extends Controller
{
    public function index(){
        $address = Address::paginate( 10 );
        $data = array (
            'code' => 200,
            'status' => 'success',
            'addresss' => $address
        );

        return response()->json($data, $data['code']);
    }

    public function store(Request $request){
  
        //verificacion de datos que este lleno 
        if (is_array($request->all())){
            //especificacion de tipado y campos requeridos 
            $rules = [
                'contact_id' => 'required|exists:contacts,id',                    
                'address' => 'max:255|string|required',  
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
                    $address = new Address();
                    $address->contact_id = $request->contact_id;            
                    $address->address = $request->address;            
                    $address->save(); 
                    $data = array(
                        'status' => 'success',
                        'code'   => '200',
                        'message' => ' address creada exitosamente'
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
                'contact_id' => 'required|exists:contacts,id',                    
                'address' => 'max:255|string|required',    
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
                    $address = Address::find( $id );

                    if( is_object($address) && !empty($address)){                
                        $address->contact_id = $request->contact_id;
                        $address->address = $request->address;
                        $address->save(); 

                        $data = array(
                         'status' => 'success',
                         'code'   => '200',
                         'message' => 'actualizado correctamente'                
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
                $address = Address::find( $id );

                if( is_object($address) && !is_null($address) ){
                    try {
                        $address->delete();

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
}
