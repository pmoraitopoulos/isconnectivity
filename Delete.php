<?php



/**
 * This class contains methods that delete parameters.
 * It is used in many occasions such as uninstall.php or custom buttons
 * 
 * 
 * @@version 1.02.01
 * @@author pmoraitop
 * 
 * 
 * 
 * 
 *Every Parameter has the following structure
 *
 *If a Parameter specified by entity id then
 *
 *  name_of_the_parameter + _ + id
 *
 *General Parameter
 *  name_of_the_parameter
 *
 *
 */


require_once WPPA_PLUGIN_DIR . '/modules/contactForm/CntcFormData.php';
require_once WPPA_PLUGIN_DIR . '/library/entityhelp.php';

class Delete{
    
/**********************
 *  Constants Section
 **********************
 *  
 *  On this section it is declared arrays for many types of 
 *  parameters. If you add new parameter ( that it saves in DB)
 *  then just add its name to the correct array.
 *  
 *  
 *  
 */
 
    
    
    
/*
 * mainAdminPageGeneralConfigurationParameters --> 
 * 
 * 
 * This array contains all parameters on Main Admin Page
 * Basically these parameters does not refer to a spesific entity
 * such as Contact Form.
 * 
 * 
 */
    public Array $mainAdminPageGeneralConfigurationParameters = array(
        'apicode_main',
        'baseurl_main',
        'loginuri_main',
        'pylonusername_main',
        'pylonpassword_',
        'applicationname_main',
        'databasealias_main',
        'cntcenabled_main',
        'postdatauri_main',
        'choice',
        'pylonapienabled'
    );
 
/*
 * 
 * cntcFormParameters -->
 * 
 * This array contains all parameters that are used in Main Page Admin
 * and they refer to a Contact Form Object.
 * 
 */
    
    public Array $cntcFormParameters = array(
        'apicode',
        'baseurl',
        'loginuri',
        'pylonusername',
        'pylonpassword',
        'applicationname',
        'databasealias',
        'cntcenabled',
        'entitycode',
        'postdatauri',
        'willsenduser'
    );
    
    
/*
 * supppageParameters -->
 * 
 * 
 * This array contains all parameters that are declared on
 * Admin Page for Support Pafe Form For Sign Up Users.
 * 
 *  
 * 
 */    
    
    
    public Array $supppageParameters = array(
        'supppageselect',
        'supppageenable',
        'redirectpageselect'
    );
    
/**********************
 * 
 * Methods Section
 * 
 **********************
 *
 *
 *On this section methods are developed. These are the main functions for 
 *reading data and delete them
 *
 *
 *
 *
 */
    
    public function __construct(){


    }
    
/*
 * deleteEverything() -->
 * 
 * As its name mention, this function delete all info for IS Connectivity Plugin
 * 
 * 
 */
    public function deleteEverything(){
        
        $this->wpisc_delete_supppage_parameters();
        
        $this->wpisc_delete_all_CntcForm_parameters();
       
        $this->wpisc_delete_admin_main_page_general_configuration_parameters();         
        
    }

/*
 * 
 * wpisc_delete_supppage_parameters()-->
 * 
 * 
 * 
 * This method deletes all parameters for Support Page for Signed Up users
 * 
 */    
    
    
    public function wpisc_delete_supppage_parameters(){
       
        foreach( $this->supppageParameters as $parameter ){
            
            $this->wpisc_delete_specific_parameter( $parameter );
        }
        
    }
    
/*
 * wpisc_delete_admin_main_page_general_configuration_parameters() -->
 * 
 * 
 * This method delete all main Page General Configuration Parameters
 * 
 * 
 */
    
    public function wpisc_delete_admin_main_page_general_configuration_parameters(){
        
        foreach( $this->mainAdminPageGeneralConfigurationParameters as $generalParameter ){
            
            $this->wpisc_delete_specific_parameter( $generalParameter );
        }
        
    }
    
/*
 * wpisc_delete_all_CntcForm_parameters() -->
 * 
 * 
 * Delete all Parameters are being saved for All Contact Forms Entitys
 * 
 * 
 */
    
    public function wpisc_delete_all_CntcForm_parameters(){
        

        $cntcForms = new CntcFormData();
        $cntcdata = $cntcForms->__getData();
        
        foreach( $cntcdata as $id => $title ){
            
            $this->wpisc_delete_spesific_CntcForm_parameters( $id );
            
        }
 
    }
    
/*
 * wpisc_delete_spesific_CntcForm_parameters( ) -->
 * 
 * 
 * It deletes all parameters are being saved for a specific Contact Form Entity ID
 */
    
    public function wpisc_delete_spesific_CntcForm_parameters( $id ){
        
        
        foreach( $this->cntcFormParameters as $parameter ){
            
            $this->wpisc_delete_specific_parameter( $parameter, $id );
            
        }
        
    }

/*
 * wpisc_delete_specific_parameter() -->
 * 
 * 
 * Fondamental function to delete a given parameter.
 * Whe can declare a name for the parameter if it is a general parameter (require)
 * or id for a parameter that it is used for an entity (entitys id) (optional)
 * 
 */
    
    public function wpisc_delete_specific_parameter( $parameter, $id=''){
        
        $underscore='';
        if( $id!='' ){
            $underscore = '_';
        }
        
        if( entityhelp::option_exists( $parameter . $underscore . $id ) == true ){
            delete_option( $parameter . $underscore . $id );
        }
        
    }
    
    
}


$Delete = new Delete();
