<?php
/**
 * Created by PhpStorm.
 * User: gaopengfei04
 * Date: 2018/2/2
 * Time: 上午12:53
 */

namespace Lps;


class Domain
{
    /**
     * @var [resource]:	libvirt domain resource
     */
    private $resource;

    /**
     * Domain constructor.
     * @param $resource
     */
    function __construct($resource){
        $this->resource = $resource;
    }


    /**
     * Function to get information whether domain is persistent or not.
     * @return mixed : TRUE for persistent, FALSE for not persistent, -1 on error
     */
    public function isPersistent(){
        return libvirt_domain_is_persistent($this->resource);
    }

    /** Function is getting information whether domain identified by resource is active or not.
     * @return mixed : virDomainIsActive() result on the domain
     */
    public function isActive(){
        return libvirt_domain_is_active($this->resource);
    }



    /** Function to set max memory for domain.
     * @param $memory  [int]:	memory size in 1024 bytes (Kb
     * @return mixed :  TRUE for success, FALSE for failure
     */
    public function setMaxMemory($memory){
        return libvirt_domain_set_max_memory($this->resource, $memory);
    }

    /** Function to set memory for domain.
     * @param $memory  memory size in 1024 bytes (Kb)
     * @return mixed TRUE for success, FALSE for failure
     */
    public function setMemory($memory){
        return libvirt_domain_set_memory($this->resource, $memory);
    }

    /** Function to set max memory for domain.
     * @param $memory memory size in 1024 bytes (Kb)
     * @param $flags bitwise-OR VIR_DOMAIN_MEM_* flags
     * @return mixed TRUE for success, FALSE for failure
     */
    public function setMemoryFlag($memory, $flags){
        return libvirt_domain_set_memory_flags($this->resource,$memory, $flags);
    }

    /** Function is getting the autostart value for the domain.
     * @return mixed autostart value or -1
     */
    public function getAutoStart(){
        return libvirt_domain_get_autostart($this->resource);
    }

    /** Function is setting the autostart value for the domain.
     * @param $flags flag to enable/disable autostart
     * @return mixed TRUE on success, FALSE on error
     */
    public function setAutotart($flags){
        return libvirt_domain_set_autostart($this->resource,$flags);
    }

    /** Function retrieve appropriate domain element given by type..
     * @param $type [int] : virDomainMetadataType type of description
     * @param $uri [string] : XML namespace identifier
     * @param $flags [int] : bitwise-OR of virDomainModificationImpact
     * @return mixed : metadata string, NULL on error or FALSE on API not supported
     */
    public function getMetaData($type, $uri, $flags){
        return libvirt_domain_get_metadata($this->resource,$type, $uri, $flags);
    }

    /**  Function sets the appropriate domain element given by type to the value of description. No new lines are permitted..
     * @param $type [int] : virDomainMetadataType type of description
     * @param $metadata [string] : new metadata text
     * @param $key [string] : XML namespace key or empty string (alias of NULL)
     * @param $uri [string] : XML namespace identifier or empty string (alias of NULL)
     * @param $flags [int] : bitwise-OR of virDomainModificationImpact
     * @return mixed : -1 on error, 0 on success
     */
    public function setMetaData($type, $metadata, $key, $uri, $flags){
        return libvirt_domain_set_metadata($this->resource,$type, $metadata, $key, $uri, $flags);
    }

    /** Function is used to lookup for domain by it's name.
     * @param $name domain name to look for
     * @return mixed : libvirt domain resource
     */
    public function lookupByName($name){
        return libvirt_domain_lookup_by_name($this->resource, $name);
    }

    /** Function is used to lookup for domain by it's UUID in the binary format.
     * @param $uuid binary defined UUID to look for
     * @return mixed : libvirt domain resource
     */
    public function lookupByUuid($uuid){
        return libvirt_domain_lookup_by_uuid($this->resource,$uuid);
    }

    /** Function is used to get the domain by it's UUID that's accepted in string format.
     * @param $uuid domain UUID [in string format] to look for
     * @return mixed : libvirt domain resource
     */
    public function lookupByUuidString($uuid){
        return libvirt_domain_lookup_by_uuid_string($this->resource, $uuid);
    }

    /** Function is used to get domain by it's ID, applicable only to running guests.
     * @param $id domain id to look for
     * @return mixed : libvirt domain resource
     */
    public function lookupById($id){
        return libvirt_domain_lookup_by_id($this->resource, $id);
    }
    /** Function is used to send qemu-ga command.
     * @param $cmd command
     * @param $timeout timeout
     * @param $flags unknown
     * @return mixed : String on success and FALSE on error
     */
    public function qemuAgentCommand($cmd, $timeout, $flags){
        return libvirt_domain_qemu_agent_command($this->resource, $cmd, $timeout, $flags);
    }
}