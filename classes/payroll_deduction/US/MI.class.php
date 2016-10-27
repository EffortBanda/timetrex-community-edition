<?php
/*********************************************************************************
 * TimeTrex is a Payroll and Time Management program developed by
 * TimeTrex Software Inc. Copyright (C) 2003 - 2013 TimeTrex Software Inc.
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
 * $Revision: 12026 $
 * $Id: MI.class.php 12026 2014-01-15 22:23:00Z mikeb $
 * $Date: 2014-01-15 14:23:00 -0800 (Wed, 15 Jan 2014) $
 */

/**
 * @package PayrollDeduction\US
 */
class PayrollDeduction_US_MI extends PayrollDeduction_US {

	var $state_options = array(
								1388563200 => array( //01-Jan-14
													'rate' => 4.25,
													'allowance' => 4000
													),
								1357027200 => array( //01-Jan-13
													'rate' => 4.25,
													'allowance' => 3950
													),
								1293858000 => array( //01-Jan-11
													'rate' => 4.35,
													'allowance' => 3700
													),
								1230796800 => array( //01-Jan-09
													'rate' => 4.35,
													'allowance' => 3600
													),
								1191222000 => array( //01-Oct-07
													'rate' => 4.35,
													'allowance' => 3400
													),
								1167638400 => array(
													'rate' => 3.9,
													'allowance' => 3400
													),
								1136102400 => array(
													'rate' => 3.9,
													'allowance' => 3300
													)
								);

	function getStatePayPeriodDeductions() {
		return bcdiv($this->getStateTaxPayable(), $this->getAnnualPayPeriods() );
	}

	function getStateAnnualTaxableIncome() {
		$annual_income = $this->getAnnualTaxableIncome();

		$allowance = $this->getStateAllowanceAmount();

		$income = bcsub( $annual_income, $allowance);

		Debug::text('State Annual Taxable Income: '. $income, __FILE__, __LINE__, __METHOD__, 10);

		return $income;
	}


	function getStateAllowanceAmount() {
		$retarr = $this->getDataFromRateArray($this->getDate(), $this->state_options);
		if ( $retarr == FALSE ) {
			return FALSE;
		}

		$allowance = $retarr['allowance'];

		$retval = bcmul( $this->getStateAllowance(), $allowance );

		Debug::text('State Allowance Amount: '. $retval, __FILE__, __LINE__, __METHOD__, 10);

		return $retval;
	}

	function getStateTaxPayable() {
		$annual_income = $this->getStateAnnualTaxableIncome();

		$retval = 0;

		if ( $annual_income > 0 ) {
			$retarr = $this->getDataFromRateArray($this->getDate(), $this->state_options);
			if ( $retarr == FALSE ) {
				return FALSE;
			}

			$rate = bcdiv( $retarr['rate'], 100);
			$retval = bcmul( $annual_income, $rate );
		}

		if ( $retval < 0 ) {
			$retval = 0;
		}

		Debug::text('State Annual Tax Payable: '. $retval, __FILE__, __LINE__, __METHOD__, 10);

		return $retval;
	}
}
?>
