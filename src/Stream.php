<?php
/**
 * Created by PhpStorm.
 * User: gaopengfei04
 * Date: 2018/2/2
 * Time: 上午1:49
 */

namespace Lps;


class Stream
{

    /**
     * Stream constructor.
     * @param $resource libvirt stream resource from Lps\Domain::createStream();
     */
    function __construct($resource){
        $this->resource = $resource;
    }

    /** Function is used to close stream.
     * @return mixed int
     */
    public function closeStream(){
        return libvirt_stream_close($this->connection);
    }

    /** Function is used to abort transfer.
     * @return mixed int
     */
    public function abortStream(){
        return libvirt_stream_abort($this->connection);
    }


    /** Function is used to finish transfer.
     * @return mixed int
     */
    public function finishStream(){
        return libvirt_stream_finish($this->connection);
    }

    /** Function is used to close stream from libvirt conn.
     * @param $data buffer
     * @param $len amout of data to recieve
     * @return mixed int
     */
    public function receiveStream($data, $len){
        return libvirt_stream_recv($this->connection, $data, $len);
    }

    /**
     * @param $data buffer
     * @param $length int amout of data to send
     * @return mixed : int
     */
    public function sendStream($data, $length){
        return libvirt_stream_send($this->connection, $data, $length);
    }
}