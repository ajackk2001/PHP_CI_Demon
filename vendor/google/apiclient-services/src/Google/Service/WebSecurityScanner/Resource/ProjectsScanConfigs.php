<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

/**
 * The "scanConfigs" collection of methods.
 * Typical usage is:
 *  <code>
 *   $websecurityscannerService = new Google_Service_WebSecurityScanner(...);
 *   $scanConfigs = $websecurityscannerService->scanConfigs;
 *  </code>
 */
class Google_Service_WebSecurityScanner_Resource_ProjectsScanConfigs extends Google_Service_Resource
{
  /**
   * Creates a new ScanConfig. (scanConfigs.create)
   *
   * @param string $parent Required. The parent resource name where the scan is
   * created, which should be a project resource name in the format
   * 'projects/{projectId}'.
   * @param Google_Service_WebSecurityScanner_ScanConfig $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_WebSecurityScanner_ScanConfig
   */
  public function create($parent, Google_Service_WebSecurityScanner_ScanConfig $postBody, $optParams = array())
  {
    $params = array('parent' => $parent, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('create', array($params), "Google_Service_WebSecurityScanner_ScanConfig");
  }
  /**
   * Deletes an existing ScanConfig and its child resources. (scanConfigs.delete)
   *
   * @param string $name Required. The resource name of the ScanConfig to be
   * deleted. The name follows the format of
   * 'projects/{projectId}/scanConfigs/{scanConfigId}'.
   * @param array $optParams Optional parameters.
   * @return Google_Service_WebSecurityScanner_WebsecurityscannerEmpty
   */
  public function delete($name, $optParams = array())
  {
    $params = array('name' => $name);
    $params = array_merge($params, $optParams);
    return $this->call('delete', array($params), "Google_Service_WebSecurityScanner_WebsecurityscannerEmpty");
  }
  /**
   * Gets a ScanConfig. (scanConfigs.get)
   *
   * @param string $name Required. The resource name of the ScanConfig to be
   * returned. The name follows the format of
   * 'projects/{projectId}/scanConfigs/{scanConfigId}'.
   * @param array $optParams Optional parameters.
   * @return Google_Service_WebSecurityScanner_ScanConfig
   */
  public function get($name, $optParams = array())
  {
    $params = array('name' => $name);
    $params = array_merge($params, $optParams);
    return $this->call('get', array($params), "Google_Service_WebSecurityScanner_ScanConfig");
  }
  /**
   * Lists ScanConfigs under a given project.
   * (scanConfigs.listProjectsScanConfigs)
   *
   * @param string $parent Required. The parent resource name, which should be a
   * project resource name in the format 'projects/{projectId}'.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string pageToken A token identifying a page of results to be
   * returned. This should be a `next_page_token` value returned from a previous
   * List request. If unspecified, the first page of results is returned.
   * @opt_param int pageSize The maximum number of ScanConfigs to return, can be
   * limited by server. If not specified or not positive, the implementation will
   * select a reasonable value.
   * @return Google_Service_WebSecurityScanner_ListScanConfigsResponse
   */
  public function listProjectsScanConfigs($parent, $optParams = array())
  {
    $params = array('parent' => $parent);
    $params = array_merge($params, $optParams);
    return $this->call('list', array($params), "Google_Service_WebSecurityScanner_ListScanConfigsResponse");
  }
  /**
   * Updates a ScanConfig. This method support partial update of a ScanConfig.
   * (scanConfigs.patch)
   *
   * @param string $name The resource name of the ScanConfig. The name follows the
   * format of 'projects/{projectId}/scanConfigs/{scanConfigId}'. The ScanConfig
   * IDs are generated by the system.
   * @param Google_Service_WebSecurityScanner_ScanConfig $postBody
   * @param array $optParams Optional parameters.
   *
   * @opt_param string updateMask Required. The update mask applies to the
   * resource. For the `FieldMask` definition, see https://developers.google.com
   * /protocol-buffers/docs/reference/google.protobuf#fieldmask
   * @return Google_Service_WebSecurityScanner_ScanConfig
   */
  public function patch($name, Google_Service_WebSecurityScanner_ScanConfig $postBody, $optParams = array())
  {
    $params = array('name' => $name, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('patch', array($params), "Google_Service_WebSecurityScanner_ScanConfig");
  }
  /**
   * Start a ScanRun according to the given ScanConfig. (scanConfigs.start)
   *
   * @param string $name Required. The resource name of the ScanConfig to be used.
   * The name follows the format of
   * 'projects/{projectId}/scanConfigs/{scanConfigId}'.
   * @param Google_Service_WebSecurityScanner_StartScanRunRequest $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_WebSecurityScanner_ScanRun
   */
  public function start($name, Google_Service_WebSecurityScanner_StartScanRunRequest $postBody, $optParams = array())
  {
    $params = array('name' => $name, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('start', array($params), "Google_Service_WebSecurityScanner_ScanRun");
  }
}
