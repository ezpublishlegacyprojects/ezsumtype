<?php

// Include the super class file
include_once( "kernel/classes/ezdatatype.php" );

class eZJSSumType extends eZDataType
{
    const DATA_TYPE_STRING = "ezjssum";

    const CLASSATTRIBUTE_SUFFIX = "data_text1";
    const CLASSATTRIBUTE_SUFFIX_FIELD = "integer_suffix";

    const OBJATTRIBUTE_SUFFIX = "data_text";
    const OBJATTRIBUTE_SUM = "data_float";
    const OBJATTRIBUTE_SUM_FIELD = "sum";

    /*!
    Construction of the class, note that the second parameter in eZDataType
    is the actual name showed in the datatype dropdown list.
    */

    function eZJSSumType()
    {
        $this->eZDataType( self::DATA_TYPE_STRING, ezi18n( 'kernel/classes/datatypes', "Integer Sum", 'Datatype name' ),
                           array( 'serialize_supported' => true,
                                  'object_serialize_map' => array( self::OBJATTRIBUTE_SUM => 'global_sum' ) ) );
    }

     /*!
     Sets the default value.
    */
    function initializeObjectAttribute( $contentObjectAttribute, $currentVersion, $originalContentObjectAttribute )
    {

        $contentClassAttribute = $contentObjectAttribute->contentClassAttribute();
        $attributeidValue = $contentClassAttribute->attribute( self::CLASSATTRIBUTE_SUFFIX );
        $contentObjectAttribute->setAttribute( self::OBJATTRIBUTE_SUFFIX, $attributeidValue );
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
        $globalnoteName = $base.'_'.self::OBJATTRIBUTE_SUM_FIELD.'_'. $contentObjectAttribute->attribute( "id" );

        if ( $http->hasPostVariable( $globalnoteName ))
        {
            $data = $http->postVariable( $globalnoteName );
            $contentObjectAttribute->setHTTPValue( $data );
            $contentObjectAttribute->setContent( $data );
            $contentObjectAttribute->setAttribute( self::OBJATTRIBUTE_SUM, $data );
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
        $attributeidName = $base.'_'.self::DATA_TYPE_STRING .'_'. self::CLASSATTRIBUTE_SUFFIX_FIELD .'_'. $classAttribute->attribute( "id" );
        if ( $http->hasPostVariable( $attributeidName ))
        {
            $attributeidValue = $http->postVariable( $attributeidName );
            $classAttribute->setAttribute( self::CLASSATTRIBUTE_SUFFIX, $attributeidValue );
            return true;
        }
        return false;
    }

    function classAttributeContent( $classAttribute )
    {
        return array(
            'suffix' => $classAttribute->attribute( self::CLASSATTRIBUTE_SUFFIX )
        );
    }

    /*!
    Returns the meta data used for storing search indices.
    */
    function metaData( $contentObjectAttribute )
    {
       return $contentObjectAttribute->attribute( self::OBJATTRIBUTE_SUM );
    }

    /*!
    Returns the content.
    */
    function objectAttributeContent( $contentObjectAttribute )
    {
       return array(
            'sum' => $contentObjectAttribute->attribute( self::OBJATTRIBUTE_SUM ),
            'suffix' => $contentObjectAttribute->attribute( self::OBJATTRIBUTE_SUFFIX )
        );
    }


    /*!
    Returns the text.
    */
    function title( $contentObjectAttribute , $name = null)
    {
       return $contentObjectAttribute->attribute( self::OBJATTRIBUTE_SUM );
    }
}


eZDataType::register( eZJSSumType::DATA_TYPE_STRING, "eZJSSumType" );

?>