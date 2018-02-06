<?php
/**
 * User: Pengfei-Gao
 * Date: 2018/2/7
 * Time: 上午12:40
 */

namespace Lps;


class Snapshot
{
    /**
     * @var [resource]:	: domain snapshot resource
     */
    private $resource;

    /**
     * Domain constructor.
     * @param $resource
     */
    function __construct($resource){
        $this->resource = $resource;
    }

    /** Function is used to get the XML description of the snapshot identified by it's resource.
     * @param $flags [int]:	libvirt snapshot flags
     * @return mixed : XML description string for the snapshot
     */
    public function getXml($flags){
        return libvirt_domain_snapshot_get_xml($this->resource, $flags);
    }

    /** Function is used to revert the domain state to the state identified by the snapshot.
     * @param $flags [int]:	libvirt snapshot flags
     * @return mixed : TRUE on success, FALSE on error
     */
    public function revert($flags){
        return libvirt_domain_snapshot_revert($this->resource, $flags);
    }

    /** Function is used to revert the domain state to the state identified by the snapshot.
     * @param $flags [int]: 0 to delete just snapshot, VIR_SNAPSHOT_DELETE_CHILDREN to delete snapshot children as well
     * @return mixed : TRUE on success, FALSE on error
     */
    public function delete($flags){
        return libvirt_domain_snapshot_delete($this->resource, $flags);
    }
}