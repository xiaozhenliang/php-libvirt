<?php
/**
 * User: Pengfei-Gao
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


    /** Function is setting the autostart value for the domain.
     * @param $flags flag to enable/disable autostart
     * @return mixed TRUE on success, FALSE on error
     */
    public function setAutotart($flags){
        return libvirt_domain_set_autostart($this->resource,$flags);
    }

    /** Function is used to change the VCPU count for the domain.
     * @param $numCpus [int] number of VCPUs to be set for the guest
     * @param $flags [int] flags for virDomainSetVcpusFlags (available at http://libvirt.org/html/libvirt-libvirt.html#virDomainVcpuFlags )
     * @return mixed : true on success, false on error
     */
    public function changeVCpus($numCpus, $flags){
        return libvirt_domain_change_vcpus($this->resource, $numCpus, $flags);
    }

    /** Function is used to change the domain memory allocation.
     * @param $allocMem number of MiBs to be set as immediate memory value
     * @param $allocMax number of MiBs to be set as the maximum allocation
     * @param $flags flags
     * @return new domain resource
     */
    public function changeMemory($allocMem, $allocMax, $flags){
        return libvirt_domain_change_memory($this->resource, $allocMem, $allocMax, $flags);
    }

    /** Function is used to change the domain boot devices.
     * @param $first first boot device to be set
     * @param $second second boot device to be set
     * @param $flags flags
     * @return mixed : new domain resource
     */
    public function changeBootDevice($first, $second, $flags){
        return libvirt_domain_change_boot_devices($this->resource, $first, $second, $flags);
    }

    /** Function is used to add the disk to the virtual machine using set of API functions to make it as simple as possible for the user.
     * @param $img string for the image file on the host system
     * @param $dev string for the device to be presented to the guest (e.g. hda)
     * @param $typ bus type for the device in the guest, usually 'ide' or 'scsi'
     * @param $driver driver type to be specified, like 'raw' or 'qcow2'
     * @param $flags flags for getting the XML description
     * @return mixed : : new domain resource
     */
    public function addDisk($img, $dev, $typ, $driver, $flags){
        return libvirt_domain_disk_add($this->resource, $img, $dev, $typ, $driver, $flags);
    }

    /** Function is used to remove the disk from the virtual machine using set of API functions to make it as simple as possible.
     * @param $dev string for the device to be removed from the guest (e.g. 'hdb')
     * @param $flags flags for getting the XML description
     * @return mixed : new domain resource
     */
    public function removeDisk($dev, $flags){
        return libvirt_domain_disk_remove($this->resource, $dev, $flags);
    }

    /** Function is used to add the NIC card to the virtual machine using set of API functions to make it as simple as possible for the user.
     * @param $mac MAC string interpretation to be used for the NIC device
     * @param $network network name where to connect this NIC
     * @param $model string of the NIC model
     * @param $flags flags for getting the XML description
     * @return mixed : new domain resource
     */
    public function addNic($mac, $network, $model, $flags){
        return libvirt_domain_nic_add($this->resource, $mac, $network, $model, $flags);
    }


    /** Function is used to remove the NIC from the virtual machine using set of API functions to make it as simple as possible.
     * @param $dev [string] string representation of the IP address to be removed (e.g. 54:52:00:xx:yy:zz)
     * @param $flags [int] optional flags for getting the XML description
     * @return mixed : new domain resource
     */
    public function removeNic( $dev, $flags){
        return libvirt_domain_nic_remove($this->resource, $dev, $flags);
    }

    /** Function is used to get network interface devices for the domain.
     * @return mixed : list of domain interface devices
     */
    public function getInterfaceDevices(){
        return libvirt_domain_get_interface_devices($this->resource);
    }

    /** Function is used to get disk devices for the domain.
     * @return mixed : list of domain disk devices
     */
    public function getDiskDevices(){
        return libvirt_domain_get_disk_devices($this->resource);
    }

    /** Function is used to get the domain's XML description.
     * @param null $xpath [string] optional xPath expression string to get just this entry, can be NULL
     * @return mixed : domain XML description string or result of xPath expression
     */
    public function getXmlDesc($xpath=null){
        return libvirt_domain_get_xml_desc($this->resource, $xpath);
    }

    /** Function is getting the autostart value for the domain.
     * @return mixed autostart value or -1
     */
    public function getAutoStart(){
        return libvirt_domain_get_autostart($this->resource);
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



    /** Function is used to create the domain identified by it's resource.
     * @return mixed : result of domain creation (startup)
     */
    public function create(){
        return libvirt_domain_create($this->resource);
    }

    /** Function is used to destroy the domain identified by it's resource.
     * @return mixed : result of domain destroy
     */
    public function destroy(){
        return libvirt_domain_destroy($this->resource);
    }


    /** Function is used to suspend the domain identified by it's resource.
     * @return mixed : TRUE for success, FALSE on error
     */
    public function suspend(){
        return libvirt_domain_suspend($this->resource);
    }

    /** Function is used to undefine the domain identified by it's resource.
     * @return mixed : TRUE for success, FALSE on error
     */
    public function undefine(){
        return libvirt_domain_undefine($this->resource);
    }

    /** Function is used to resume the domain identified by it's resource.
     * @return mixed : result of domain resume
     */
    public function resume(){
        return libvirt_domain_resume($this->resource);
    }


    /** Function is used to dump core of the domain identified by it's resource.
     * @param $to to
     * @return mixed : TRUE for success, FALSE on error
     */
    public function coreDump($to){
        return libvirt_domain_core_dump($this->resource,$to);
    }

    /** Function is used to shutdown the domain identified by it's resource.
     * @return mixed : TRUE for success, FALSE on error
     */
    public function shutdown(){
        return libvirt_domain_shutdown($this->resource);
    }


    /** Function is used to reboot the domain identified by it's resource.
     * @param $flags optional flags
     * @return mixed : TRUE for success, FALSE on error
     */
    public function reboot($flags = 1){
        return libvirt_domain_reboot($this->resource, $flags);
    }

    /** Function is used to create the domain identified by it's resource.
     * @return mixed : newly started/created domain resource
     */
    public function start(){
        return libvirt_domain_create_xml( $this->getConnectResource(),$this->getXmlDesc());
    }

    /** Function is used to managed save the domain (domain was unloaded from memory and it state saved to disk) identified by it's resource.
     * @return mixed : TRUE for success, FALSE on error
     */
    public function managedSave(){
        return libvirt_domain_managedsave($this->resource);
    }

    /** Function is used to get the domain's memory peek value.
     * @param $start start
     * @param $size size
     * @param $flags optional flags
     * @return mixed : domain memory peek
     */
    public function getMemoryPeek($start, $size, $flags){
        return libvirt_domain_memory_peek($this->resource, $start, $size, $flags);
    }

    /** Function is used to get the domain's memory stats.
     * @param $flags optional flags
     * @return mixed : domain memory stats array (same fields as virDomainMemoryStats, please see libvirt documentation)
     */
    public function getMemoryStats($flags){
        return libvirt_domain_memory_stats($this->resource, $flags);
    }

    /** Function is used to get the domain's block stats.
     * @param $path [string]:	device path to get statistics about
     * @return mixed : domain block stats array, fields are rd_req, rd_bytes, wr_req, wr_bytes and errs
     */
    public function getBlockStats($path){
        return libvirt_domain_block_stats($this->resource, $path);
    }

    /** Function is used to resize the domain's block device.
     * @param $path [string]:	device path to resize
     * @param $size [int]:	size of device
     * @param $flags [int]:	bitwise-OR of VIR_DOMAIN_BLOCK_RESIZE_*
     * @return bool 	: true on success fail on error
     */
    public function resizeBlock( $path, $size, $flags){
        return libvirt_domain_block_resize($this->resource,$path, $size, $flags);
    }


    /** Function is used to commit block job.
     * @param $disk [string]:	path to the block device, or device shorthand
     * @param $base [string]:	path to backing file to merge into, or device shorthand, or NULL for default
     * @param $top [string]:	path to file within backing chain that contains data to be merged, or device shorthand, or NULL to merge all possible data
     * @param $bandwidth  [int]:	(optional) specify bandwidth limit; flags determine the unit
     * @param $flags [int]:	bitwise-OR of VIR_DOMAIN_BLOCK_COMMIT_*
     * @return mixed 	: true on success fail on error
     */
    public function commitBlock($disk, $base, $top, $bandwidth, $flags){
        return libvirt_domain_block_commit($this->resource, $disk, $base, $top, $bandwidth, $flags);
    }

    /** Function is used to update the domain's devices from the XML string.
     * @param $xml [xml] XML string for the update
     * @param $flags [int] Flags to update the device (VIR_DOMAIN_DEVICE_MODIFY_CURRENT, VIR_DOMAIN_DEVICE_MODIFY_LIVE, VIR_DOMAIN_DEVICE_MODIFY_CONFIG, VIR_DOMAIN_DEVICE_MODIFY_FORCE)
     * @return mixed : TRUE for success, FALSE on error
     */
    public function updateDevice($xml, $flags){
        return libvirt_domain_update_device($this->resource, $xml, $flags);
    }

    /** Function is used to abort block job.
     * @param $path device path to resize
     * @param $flags bitwise-OR of VIR_DOMAIN_BLOCK_JOB_ABORT_*
     * @return mixed : true on success fail on error
     */
    public function abortBlockJob($path, $flags){
        return libvirt_domain_block_job_abort($this->resource, $path, $flags);
    }

    /** Function is used to set speed of block job.
     * @param $path device path to resize
     * @param $bandwidth bandwidth
     * @param $flags bitwise-OR of VIR_DOMAIN_BLOCK_JOB_SPEED_BANDWIDTH_*
     * @return mixed : true on success fail on error
     */
    public function setBlockJobSpeed($path, $bandwidth, $flags){
         return libvirt_domain_block_job_set_speed($this->resource, $path, $bandwidth, $flags);
    }

    /** Function is used to get the domain's network information.
     * @param $mac mac address of the network device
     * @return mixed  : domain network info array of MAC address, network name and type of NIC card
     */
    public function getNetworkInfo($mac){
        return libvirt_domain_get_network_info($this->resource, $mac);
    }

    /** Function is used to get the domain's block device information.
     * @param $dev device to get block information about
     * @return mixed : domain block device information array of device, file or partition, capacity, allocation and physical size
     */
    public function getBlockInfo($dev){
        return libvirt_domain_get_block_info($this->resource, $dev);
    }

    /** Function is used to get the domain's interface stats.
     * @param $path path to interface device
     * @return mixed : interface stats array of {tx|rx}_{bytes|packets|errs|drop} fields
     */
    public function getInterfaceStats($path){
        return libvirt_domain_interface_stats($this->resource, $path);
    }

    /** Function is used to get the domain's connection resource. This function should *not* be used!.
     * @return mixed : libvirt connection resource
     */
    public function getConnectResource(){
        return libvirt_domain_get_connect($this->resource);
    }

    /** Function is used migrate domain to another libvirt daemon specified by it's URI.
     * @param $dest_uri [string]:	destination URI to migrate to
     * @param $flags [int]:	migration flags
     * @param $dname [string]:	domain name to rename domain to on destination side
     * @param $bandwidth [int]:	migration bandwidth in Mbps
     * @return mixed 	: TRUE for success, FALSE on error
     */
    public function migrateToUri($dest_uri, $flags, $dname, $bandwidth){
        return libvirt_domain_migrate_to_uri($this->resource, $dest_uri, $flags, $dname, $bandwidth);
    }

    /** Function is used migrate domain to another libvirt daemon specified by it's URI.
     * @param $dconnuri [string]:	URI for target libvirtd
     * @param $miguri [string]:	URI for invoking the migration
     * @param $dxml [string]:	XML config for launching guest on target
     * @param $flags [int]:	migration flags
     * @param $dname [string]:	domain name to rename domain to on destination side
     * @param $bandwidth [int]:	migration bandwidth in Mbps
     * @return mixed : TRUE for success, FALSE on error
     */
    public function migrateToUri2($dconnuri, $miguri, $dxml, $flags, $dname, $bandwidth){
        return libvirt_domain_migrate_to_uri2($this->resource, $dconnuri, $miguri, $dxml, $flags, $dname, $bandwidth);
    }


    /** Function is used migrate domain to another domain.
     * @param $dest_conn [string]:	destination host connection object
     * @param $flags [int]:	migration flags
     * @param $dname [string]:	domain name to rename domain to on destination side
     * @param $bandwidth [int]:	migration bandwidth in Mbps
     * @return mixed : libvirt domain resource for migrated domain
     */
    public function migrate($dest_conn, $flags, $dname, $bandwidth){
        return libvirt_domain_migrate($this->resource, $dest_conn, $flags, $dname, $bandwidth);
    }

    /** Function is used get job information for the domain.
     * @return mixed : job information array of type, time, data, mem and file fields
     */
    public function getJobInfo(){
        return libvirt_domain_get_job_info($this->resource);
    }

    /** Function is used to get the information whether domain has the current snapshot.
     * @param $flags [int]:	libvirt snapshot flags
     * @return mixed : TRUE is domain has the current snapshot, otherwise FALSE (you may need to check for error using libvirt_get_last_error())
     */
    public function hasCurrentSnapshot($flags){
        return libvirt_domain_has_current_snapshot($this->resource, $flags);
    }

    /** This functions is used to lookup for the snapshot by it's name.
     * @param $name [string]:	name of the snapshot to get the resource
     * @param $flags [int]:	libvirt snapshot flags
     * @return mixed : domain snapshot resource
     */
    public function loookupSnapshotByName($name, $flags){
        return libvirt_domain_snapshot_lookup_by_name($this->resource, $name, $flags);
    }

    /** This function creates the domain snapshot for the domain identified by it's resource.
     * @param $flags [int]:	libvirt snapshot flags
     * @return mixed 	: domain snapshot resource
     */
    public function createSnapshot($flags){
        return libvirt_domain_snapshot_create($this->resource, $flags);
    }

    /** Function is used to list domain snapshots for the domain specified by it's resource.
     * @param $flags [int]:	libvirt snapshot flags
     * @return mixed : libvirt domain snapshot names array
     */
    public function getSnapshotList($flags){
        return libvirt_list_domain_snapshots($this->resource, $flags);
    }
}