<?php
namespace Lps;
class Libvirt {
    
    private $connection;
    
    /**
     * @url [string]:	URI for connection
     * @readonly [bool]:	flag whether to use read-only connection or not
     * @credentials [array]:	array of connection credentials
     */
    function __construct($uri = "qemu:///system", $readonly = true, $credentials = false){
       $this->connection = $credentials ? libvirt_connect($uri, $readonly,$credentials) : libvirt_connect($uri, $readonly) ;
    }

    /**
     * Function is used to get the information about host node, mainly total memory installed, total CPUs installed and model information are useful.
     * @conn [resource]:	resource for connection
     * @Return [mix]:	: array of node information or FALSE for error
     */
    public function getNodeInfo(){
        return libvirt_node_get_info($this->connection);
    }
    
    /**
     * Function is used to get the hostname of the guest associated with the connection.
     * @conn [resource]:	resource for connection
     * @Return [mix]:	: hostname of the host node or FALSE for error
     */
    public function getHostName(){
        return libvirt_connect_get_hostname($this->connection);
    }

    /**
     * Function is used to get the connection URI. This is useful to check the hypervisor type of host machine when using "null" uri to libvirt_connect().
     * @conn [resource]:	resource for connection
     * @Return:	: connection URI string or FALSE for error
     */
    public function getUri(){
        return libvirt_connect_get_uri($this->connection);
    }

    /**
     * Function is used to create the image of desired name, size and format. The image will be created in the image path (libvirt.image_path INI variable). Works only o.
     * @name [string]:	name of the image file that will be created in the libvirt.image_path directory
     * @size [int]:	size of the image in MiBs
     * @format [string]:	format of the image, may be raw, qcow or qcow2
     * @Return:	: hostname of the host node or FALSE for error
     */
    public function createImage($name, $size = 500, $format='raw'){
        return libvirt_image_create($this->connection,$name, $size, $format);
    }
    /**
     * Function is used to create the image of desired name, size and format. The image will be created in the image path (libvirt.image_path INI variable). Works only on local systems!.
     * @image [string]:	name of the image file that should be deleted
     * Returns:	: hostname of the host node or FALSE for error
     */ 
    public function deleteImage($image){
        return libvirt_image_remove($this->connection,$image);
    }
    
    /**
     * Function is used to get the information about the hypervisor on the connection identified by the connection pointer.
     * Returns:	: array of hypervisor information if available
     */
    public function getHypervisor(){
        return libvirt_connect_get_hypervisor($this->connection);
    }
    /**
     * Function is used to get the information whether the connection is encrypted or not.
     * Returns:	: 1 if encrypted, 0 if not encrypted, -1 on error
     */
    public function isEncrypted(){
        return libvirt_connect_is_encrypted($this->connection);
    }
}
