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
     * @return mixed : hostname of the host node or FALSE for error
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

    /**
     * Function is used to get maximum number of VCPUs per VM on the hypervisor connection.
     * Returns:	: number of VCPUs available per VM on the connection or FALSE for error
     */
    public function getSysInfo(){
        return libvirt_connect_get_sysinfo($this->connection);
    }

    /**
     * Function is getting domain counts for all, active and inactive domains.
     * Returns:	: array of total, active and inactive (but defined) domain counts
     */
    public function getDomainCount(){
        return libvirt_domain_get_counts($this->connection);
    }

    /** Function is used to create new stream from libvirt conn
     * @return mixed : resource libvirt stream resource
     */
    public function createStream(){
        return  libvirt_stream_create($this->connection);
    }

    /** Function is used to install a new virtual machine to the machine.
     * @param $name [string] name of the new domain
     * @param $arch [string] optional architecture string, can be NULL to get default (or false)
     * @param $memMB [int] number of megabytes of RAM to be allocated for domain
     * @param $maxmemMB [int] maximum number of megabytes of RAM to be allocated for domain
     * @param $vcpus [int] number of VCPUs to be allocated to domain
     * @param $iso_image [string] installation ISO image for domain
     * @param $disks [array] array of disk devices for domain, consist of keys as 'path' (storage location), 'driver' (image type, e.g. 'raw' or 'qcow2'), 'bus' (e.g. 'ide', 'scsi'), 'dev' (device to be presented to the guest - e.g. 'hda'), 'size' (with 'M' or 'G' suffixes, like '10G' for 10 gigabytes image etc.) and 'flags' (VIR_DOMAIN_DISK_FILE or VIR_DOMAIN_DISK_BLOCK, optionally VIR_DOMAIN_DISK_ACCESS_ALL to allow access to the disk for all users on the host system)
     * @param $networks [array] array of network devices for domain, consists of keys as 'mac' (for MAC address), 'network' (for network name) and optional 'model' for model of NIC device
     * @param $flags bit array of flags
     * @return mixed a new domain resource
     */
    public function createDomain( $name, $arch, $memMB, $maxmemMB, $vcpus, $iso_image, $disks, $networks, $flags = null){
        return libvirt_domain_new($this->connection, $name, $arch, $memMB, $maxmemMB, $vcpus, $iso_image, $disks, $networks, $flags);
    }

    /** Function is used to get the VNC server location for the newly created domain (newly started installation).
     * @return mixed  : a VNC server for a newly created domain resource (if any)
     */
    public function getNewDomainVnc(){
        return libvirt_domain_new_get_vnc();
    }

    /** Function is used to define the domain from XML string.
     * @param $xml XML string to define guest from
     * @return mixed : newly defined domain resource
     */
    public function defineDomainByXml($xml){
        return libvirt_domain_define_xml($this->connection, $xml);
    }

    /** Function is used to create the domain identified by it's resource.
     * @param $xml XML string to create guest from
     * @return mixed : newly started/created domain resource
     */
    public function createDomainByXml($xml){
        return libvirt_domain_create_xml($this->connection, $xml);
    }

    /** Function is used to list domains on the connection.
     * @return mixed : libvirt domain names array for the connection
     */
    public function listDomains(){
        return libvirt_list_domains($this->connection);
    }

    /** Function is used to list domain resources on the connection.
     * @return mixed : libvirt domain resources array for the connection
     */
    public function listDomainResources(){
        return libvirt_list_domain_resources($this->connection);
    }

    /** Function is used to list active domain names on the connection.
     * @return mixed : libvirt active domain names array for the connection
     */
    public function listActiveDomains(){
        return libvirt_list_active_domains($this->connection);
    }

    /** Function is used to list inactive domain names on the connection.
     * @return mixed : libvirt inactive domain names array for the connection
     */
    public function listInactiveDomains(){
        return libvirt_list_inactive_domains($this->connection);
    }

    /** flags whether to list active, inactive or all networks (VIR_NETWORKS_{ACTIVE|INACTIVE|ALL} constants)
     * @param $flags flags whether to list active, inactive or all networks (VIR_NETWORKS_{ACTIVE|INACTIVE|ALL} constants)
     * @return mixed : libvirt network names array for the connection
     */
    public function listNetworks($flags){
        return libvirt_list_networks($this->connection, $flags);
    }

    /** Function is used to list node devices on the connection.
     * @param $cap [string]:	optional capability string
     * @return mixed : libvirt nodedev names array for the connection
     */
    public function listNodeDevs($cap){
        return libvirt_list_nodedevs($this->connection, $cap);
    }

    /** Function is used to lookup for storage pool by it's name.
     * @param $name [string]:	storage pool name
     * @return mixed : libvirt storagepool resource
     */
    public function lookupStoragePoolByName($name){
        return libvirt_storagepool_lookup_by_name($this->connection, $name);
    }
}
