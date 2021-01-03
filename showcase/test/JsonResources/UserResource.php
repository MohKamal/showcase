<?php
namespace Showcase\JsonResources{
    use \Showcase\Framework\HTTP\Resources\JsonResource;
    
    class UserResource extends JsonResource{       

        /**
         * Init the resource with model
         * @return json
         */
        public function __construct($obj){
            JsonResource::__construct($obj);
        }

        /**
         * Set the properties to return
         * @return array
         */
        function handle(){
            return [
                'maticule' => $this->id,
                'adresse_email' => $this->email,
                'codePromo' => "er15cc52",
            ];
        }
    }
}