<?php
// $Id$

/**
 * @file
 * User page callbacks for the oauth module.
 */

/**
 * Menu callback; Manage OAuth based identities for the specified user.
 */
function oauth_user_identities($account) {
  $header = array(t('External identity'), t('Operations'));
  $rows = array();

  $result = db_select('authmap')
  ->fields('authmap')
  ->condition('uid', $account->uid)
  ->execute()
  ->fetchAllAssoc('module');

  $oauth_modules = oauth_get_implementations();

  foreach ($oauth_modules as $key => $module) {
    if (isset($result[$key])) {
      $identity = $result[$key];
      $operations = l(t('Delete'), "user/$account->uid/$key/delete/" . $identity->aid);
    }
    else {
      $identity->authname = $module['name'];
      $operations = l(t('Add'), "$key/authenticate");
    }
    // TODO: Better display (Username) and Logo (Twitter, Facebook...).
    $rows[] = array(check_plain($identity->authname), $operations);
  }

  $build['oauth_table'] = array(
    '#theme' => 'table',
    '#header' => $header,
    '#rows' => $rows,
  );
  return $build;
}

/**
 * Menu callback; Delete the specified OAuth based identity from the system.
 */
function oauth_user_delete_form($form, $form_state, $account, $module, $aid = 0) {
  $authname = db_query("SELECT authname FROM {authmap} WHERE uid = :uid AND aid = :aid AND module = :module", array(
    ':uid' => $account->uid,
    ':aid' => $aid,
    ':module' => $module,
  ))
  ->fetchField();

  $infos = module_invoke($module, 'oauth_info');
  $form_state['storage'] = $infos;

  return confirm_form(array(), t('Are you sure you want to delete the %module account for %user?', array('%module' => $infos['name'], '%user' => $account->name)), 'user/' . $account->uid . '/identities');
}

// TODO: maybe use a oauth_user_delete function like oauth_user_add
// unified API to delete user oauth related data.
function oauth_user_delete_form_submit($form, &$form_state) {
  $uid = $form_state['build_info']['args'][0]->uid;
  $aid = $form_state['build_info']['args'][2];
  $module = $form_state['build_info']['args'][1];

  $query = db_delete('authmap')
    ->condition('uid', $uid)
    ->condition('aid', $aid)
    ->condition('module', $module)
    ->execute();

  db_delete($module . '_token')
    ->condition('uid', $uid)
    ->execute();

  if ($query) {
    drupal_set_message(t('@module account deleted.', array('@module' => $form_state['storage']['name'])));
  }
  $form_state['redirect'] = 'user/' . $form_state['build_info']['args'][0]->uid . '/identities';
}