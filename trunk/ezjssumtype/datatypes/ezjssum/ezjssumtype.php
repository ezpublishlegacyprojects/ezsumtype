<?php

// Include the super class file
include_once( "kernel/classes/ezdatatype.php" );

class eZJSSumType extends eZDataType
{
    const DATA_TYPE_STRING = "ezjssum";
    const ATTRIBUTE_ID_PART_FIELD = "data_text1";
    const ATTRIBUTE_ID_PART_VARIABLE = "integer_suffix";    
    
    /*!
    Construction of the class, note that the second parameter in eZDataType 
    is the actual name showed in the datatype dropdown list.
    */
    
    function eZJSSumType()
    {
        $this->eZDataType( self::DATA_TYPE_STRING, ezi18n( 'kernel/classes/datatypes', "Integer Sum", 'Datatype name' ),
                           array( 'serialize_supported' => true,
                                  'object_serialize_map' => array( 'data_float' => 'global_sum' ) ) );
    }
    
     /*!
     Sets the default value.
    */
    function initializeObjectAttribute( $contentObjectAttribute, $currentVersion, $originalContentObjectAttribute )
    {   
		$contentClassAttribute = $contentObjectAttribute->contentClassAttribute();
        $attributeidValue = $contentClassAttribute->attribute( self::ATTRIBUTE_ID_PART_FIELD );
        $contentObjectAttribute->setAttribute( 'data_text', $attributeidValue );
    }
    
    
    /*!
     Validates the input and returns true if the input was
     valid for this datatype.
    */
    function validateObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {    
        return eZInputValidator::STATE_ACCEPTED;
    }
    
    
    /*!
     Fetches the http post var integer input and stores it in the data instance.
    */
    function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {    
		$globalnoteName = $base.'_data_float_'. $contentObjectAttribute->attribute( "id" );
		if ( $http->hasPostVariable( $globalnoteName ))
        {
 			$data = $http->postVariable( $globalnoteName );
            $contentObjectAttribute->setHTTPValue( $data );
            $contentObjectAttribute->setContent( $data );    
            $contentObjectAttribute->setAttribute( "data_float", $data );

            return true;
        }
        return false;        
    }
    
    /*!
    Store the content. Since the content has been stored in function 
    fetchObjectAttributeHTTPInput(), this function is with empty code.
    */
    
    function storeObjectAttribute( $contentObjectattribute )
    {

    }
    
    function storeClassAttribute( $attribute, $version )
    {    
    }
    
    /*!
     Validates the input and returns true if the input was
     valid for this datatype.
    */
    function validateClassAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        return eZInputValidator::STATE_ACCEPTED;
    }
    
    
    /*!
     Fetches the http post var integer input and stores it in the data instance.
    */
    function fetchClassAttributeHTTPInput( $http, $base, $classAttribute )
    {
		$attributeidName = $base.'_'.self::DATA_TYPE_STRING .'_'. self::ATTRIBUTE_ID_PART_VARIABLE .'_'. $classAttribute->attribute( "id" );
		if ( $http->hasPostVariable( $attributeidName ))
        {
        	$attributeidValue = $http->postVariable( $attributeidName );        
            $classAttribute->setAttribute( self::ATTRIBUTE_ID_PART_FIELD, $attributeidValue );
            
            return true;
        }
        return false;
    }
    
	/*!
    Returns the meta data used for storing search indices.
    */
    function metaData( $contentObjectAttribute )
    {
       return $contentObjectAttribute->attribute( "data_float" );
    }

    /*!
    Returns the content.
    */
    function objectAttributeContent( $contentObjectAttribute )
    {
       return $contentObjectAttribute->attribute( "data_float" );
    }
    
    
    /*!
    Returns the text.
    */
    function title( $contentObjectAttribute , $name = null)
    {
       return $contentObjectAttribute->attribute( "data_float" );
    }
}

 
eZDataType::register( eZJSSumType::DATA_TYPE_STRING, "eZJSSumType" );

?>