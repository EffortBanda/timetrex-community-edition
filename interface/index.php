<?php
/*********************************************************************************
 * TimeTrex is a Payroll and Time Management program developed by
 * TimeTrex Software Inc. Copyright (C) 2003 - 2014 TimeTrex Software Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by
 * the Free Software Foundation with the addition of the following permission
 * added to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED
 * WORK IN WHICH THE COPYRIGHT IS OWNED BY TIMETREX, TIMETREX DISCLAIMS THE
 * WARRANTY OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along
 * with this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact TimeTrex headquarters at Unit 22 - 2475 Dobbin Rd. Suite
 * #292 Westbank, BC V4T 2E9, Canada or at email address info@timetrex.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Powered by TimeTrex" logo. If the display of the logo is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Powered by TimeTrex".
 ********************************************************************************/
/*
 * $Revision: 13366 $
 * $Id: index.php 13366 2014-06-09 17:15:19Z mikeb $
 * $Date: 2014-06-09 10:15:19 -0700 (Mon, 09 Jun 2014) $
 */
require_once('../includes/global.inc.php');
$form_vars = FormVariables::GetVariables( array('desktop') );
if ( array_key_exists( 'desktop', $form_vars ) AND $form_vars['desktop'] != 1 ) { //isset() won't work here as 'desktop' key can be NULL
	unset($form_vars['desktop']);
}

if ( isset($config_vars['other']['default_interface']) AND strtolower($config_vars['other']['default_interface']) == 'html5' ) {
	Redirect::Page( URLBuilder::getURL( $form_vars, Environment::GetBaseURL().'html5/') );
} else {
	Redirect::Page( URLBuilder::getURL( $form_vars, Environment::GetBaseURL().'flex/') );
}
?>