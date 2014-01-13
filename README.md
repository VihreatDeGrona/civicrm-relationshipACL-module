civicrm-relationshipACL-module
==============================

[CiviCRM] (https://civicrm.org/) module to use contact relationships edit rights to determine contact visibility and editability in ACL. This module uses [civicrm_aclWhereClause hook] (http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_aclWhereClause).

This module allows to use relationships intead of groups or as additional feature of ACL. The whole relationship tree is searched and all contacts to where user has edit permissions through relationships are made visible and editable. All contact types are searched.

Large portions of this module is based on the [Relationship Permissions as ACLs] (https://civicrm.org/extensions/relationship-permissions-acls) extension.

### Example
* Organisation 1
* Sub-organisation 1 (Organisation 1 has edit relationship to this organisation)
* Sub-organisation 2 (Sub-organisation 1 has edit relationship to this organisation)
* User 1 (has edit relationship to Organisation 1)

With this module User 1 can see and edit Organisation 1, Sub-organisation 1 and Sub-organisation 2.

### Installation
Copy _com.github.anttikekki.relationshipACL_ folder to CiviCRM extension folder and enable extension in administration.

This module uses temporary tables in database so CiviCRM MySQL user has to have permissions to create these kind of tables.

### Performance considerations
This module performance on large CiviCRM sites may be poor. Used aclWhereClause hook allows to modify SQL WHERE clause in ACL check. This means the module needs to determine the relationship tree structure on every ACL query. The relationship tree may be deep and complex. This means 1 query for every relationship level. The search done with help of temporary table in database.

This logic may lead to multiple large queries and large temporary table on every page load in contact administration.

### Licence
GNU Affero General Public License
