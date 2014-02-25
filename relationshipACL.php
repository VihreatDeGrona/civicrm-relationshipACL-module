<?php

/**
* CiviCRM module extension. Hooks to ACL check to allow relationships to define contact visibility.
* This module searches all the contacts that user has right to edit through relationships.
*
* Portions of this file is based off the Relationship Permissions as ACLs extension:
* https://civicrm.org/extensions/relationship-permissions-acls
*/

if(class_exists('RelationshipACLQueryWorker') === false) {
  require_once "RelationshipACLQueryWorker.php";
  
}
RelationshipACLQueryWorker::checkVersion("1.1");


/*
 * Implement civicrm_aclWhereClause hook.
 *
 * Searches the whole relationships tree structure and finds all the contacts that given contact id 
 * has right to edit.
 *
 * @param int $type - type of permission needed
 * @param array $tables - (reference ) add the tables that are needed for the select clause
 * @param array $whereTables - (reference ) add the tables that are needed for the where clause
 * @param int $contactID - the contactID for whom the check is made
 * @param string $where - the currrent where clause
 */
function relationshipACL_civicrm_aclWhereClause($type, &$tables, &$whereTables, &$contactID, &$where) {
  if (!$contactID) {
    return;
  }
  
  $worker = RelationshipACLQueryWorker::getInstance();
  $tmpTableName = $worker->createContactsTableWithEditPermissions($contactID);

  $tables ['$tmpTableName'] = $whereTables ['$tmpTableName'] =
    " LEFT JOIN $tmpTableName permrelationships
     ON (contact_a.id = permrelationships.contact_id)";
  
  if(empty($where)){
    $where = " permrelationships.contact_id IS NOT NULL ";
  }
  else{
    $where .= " AND permrelationships.contact_id IS NOT NULL ";
  }
}