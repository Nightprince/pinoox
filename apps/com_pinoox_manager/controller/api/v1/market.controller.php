<?php
/**
 *      ****  *  *     *  ****  ****  *    *
 *      *  *  *  * *   *  *  *  *  *   *  *
 *      ****  *  *  *  *  *  *  *  *    *
 *      *     *  *   * *  *  *  *  *   *  *
 *      *     *  *    **  ****  ****  *    *
 * @author   Pinoox
 * @link https://www.pinoox.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */

namespace pinoox\app\com_pinoox_manager\controller\api\v1;

use pinoox\app\com_pinoox_manager\component\Wizard;
use pinoox\app\com_pinoox_manager\model\AppModel;
use pinoox\component\Config;
use pinoox\component\Dir;
use pinoox\component\Download;
use pinoox\component\File;
use pinoox\component\HelperHeader;
use pinoox\component\Request;
use pinoox\component\Response;
use pinoox\component\Url;

class MarketController extends MasterConfiguration
{
    public function getApps($keyword = '')
    {
        $data = Request::sendGet('https://www.pinoox.com/api/manager/v1/market/get/' . $keyword);
        HelperHeader::contentType('application/json', 'UTF-8');
        echo $data;
    }

    public function getOneApp($package_name)
    {

        $data = Request::sendGet("https://www.pinoox.com/api/manager/v1/market/getApp/".$package_name);
        HelperHeader::contentType('application/json', 'UTF-8');
        $arr = json_decode($data, true);

        //check app state
        $arr['state'] = 'download';
        $file = Dir::path('downloads>apps>' . $package_name . '.pin');
        if (Wizard::is_installed($package_name))
            $arr['state'] = 'installed';
        else if (file_exists($file))
            $arr['state'] = 'install';

        Response::json($arr);

    }

    public function downloadRequest($package_name)
    {
        $auth = Request::inputOne('auth');
        $app = AppModel::fetch_by_package_name($package_name);
        if (!empty($app))
            Response::json(rlang('manager.currently_installed'), false);

        $pinVer = Config::get('~pinoox');
        $params = [
            'token' => $auth['token'],
            'remote_url' => Url::site(),
            'user_agent' => HelperHeader::getUserAgent() . ';Pinoox/' . $pinVer['version_name'] . ' Manager',
        ];
        $res = Request::sendPost('https://www.pinoox.com/api/manager/v1/market/downloadRequest/' . $package_name, $params);
        if (!empty($res)) {
            $response = json_decode($res, true);
            if (!$response['status']) {
                exit($res);
            } else {
                $path = path("downloads>apps>" . $package_name . ".pin");
                Config::set('market.'.$package_name, json_encode([$package_name => $response['result']]));
                Config::save('market');
                Download::fetch('https://www.pinoox.com/api/manager/v1/market/download/' . $response['result']['hash'], $path)->process();
                Response::json(rlang('manager.download_completed'), true);
            }
        }
    }
}
