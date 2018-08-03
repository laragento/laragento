<?php
/**
 * Created by PhpStorm.
 * User: KARLEN
 * Date: 03.08.2018
 * Time: 12:07
 */

namespace Laragento\Quote\Repositories;


interface QuoteSessionAddressRepositoryInterface
{
    /**
     * @return mixed
     */
    public function get();

    /**
     * @param $data
     * @return mixed
     */
    public function create($data);

    /**
     * @param $id
     * @return mixed
     */
    public function byId($id);

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);

}