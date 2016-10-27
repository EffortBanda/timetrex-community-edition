<?php
/*********************************************************************************
 * TimeTrex is a Workforce Management program developed by
 * TimeTrex Software Inc. Copyright (C) 2003 - 2016 TimeTrex Software Inc.
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
 * #292 West Kelowna, BC V4T 2E9, Canada or at email address info@timetrex.com.
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


include_once( dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'GovernmentForms_Base.class.php' );

/**
 * @package GovernmentForms
 */
class GovernmentForms_CA extends GovernmentForms_Base {
	function filterMiddleName( $value ) {
		//Return just initial
		$value = substr( $value, 0, 1);
		return $value;
	}

	function filterCompanyAddress( $value ) {
		//Combine company address for multicell display.
		return Misc::formatAddress( NULL, $this->company_address1, $this->company_address2, $this->company_city, $this->company_province, $this->company_postal_code );
	}
	
	function filterAddress( $value ) {
		//Combine company address for multicell display.
		return Misc::formatAddress( NULL, $this->address1, $this->address2, $this->city, $this->province, $this->postal_code, $this->country ); //Include country in case they are outside of Canada.
	}
	
	function formatPayrollAccountNumber( $value ) {
		$value = str_replace(' ', '', $value );
		return $value;
	}
	
	function filterPayrollAccountNumber( $value ) {
		$value = $this->formatPayrollAccountNumber( $value );
		if ( $this->getType() == 'employee' ) {
			$value = $this->payroll_account_number = '***************'; //Hide payroll account number on employees copy for security reasons.
		} else {
			$value = $this->payroll_account_number;
		}
		return $value;
	}
}
?>