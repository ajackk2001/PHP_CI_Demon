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

class Google_Service_HangoutsChat_ImageButton extends Google_Model
{
  public $icon;
  public $iconUrl;
  public $name;
  protected $onClickType = 'Google_Service_HangoutsChat_OnClick';
  protected $onClickDataType = '';

  public function setIcon($icon)
  {
    $this->icon = $icon;
  }
  public function getIcon()
  {
    return $this->icon;
  }
  public function setIconUrl($iconUrl)
  {
    $this->iconUrl = $iconUrl;
  }
  public function getIconUrl()
  {
    return $this->iconUrl;
  }
  public function setName($name)
  {
    $this->name = $name;
  }
  public function getName()
  {
    return $this->name;
  }
  /**
   * @param Google_Service_HangoutsChat_OnClick
   */
  public function setOnClick(Google_Service_HangoutsChat_OnClick $onClick)
  {
    $this->onClick = $onClick;
  }
  /**
   * @return Google_Service_HangoutsChat_OnClick
   */
  public function getOnClick()
  {
    return $this->onClick;
  }
}
