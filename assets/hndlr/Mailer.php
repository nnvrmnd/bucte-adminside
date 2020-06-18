<?php
require_once '../../../assets/lib/PHPMailer/src/Exception.php';
require_once '../../../assets/lib/PHPMailer/src/PHPMailer.php';
require_once '../../../assets/lib/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function Mailer($event, $recipients) {
	require './Dispatcher.php';
	$server_url = $_SERVER['SERVER_NAME'];
	$domain = $server_url . '/app/';

	// $verification_link = $domain . 'login.php';
	// $verification_link .= '?e=' . str_replace('@', '%40', $email);
	// $signature = md5($expiration . '_' . $email);
	// $verification_link .= '&s=' . $signature;

	// Instantiation and passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try {
		//Server settings
		$mail->isSMTP();
		$mail->SMTPSecure = 'ssl';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = '465';
		$mail->SMTPAuth = true;
		$mail->Username = $dispatcher;
		$mail->Password = $key;

		//Recipients
		$mail->setFrom('noreply.bucte@gmail.com', 'BU Center for Teaching Excellence');
		$mail->addAddress($email);
		$mail->addReplyTo('noreply.bucte@gmail.com', 'No reply');

		// Content
		$mail->isHTML(true);
		$mail->Subject = 'Thank you for attending {EVENT}';
		$mail->Body = '
			<!DOCTYPE html>
			<html>

				<head>
					<title>Verify Email Address
					</title>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<meta name="viewport" content="width=device-width, initial-scale=1">
					<meta http-equiv="X-UA-Compatible" content="IE=edge">
					<style type="text/css">
						body,
						table,
						td,
						a {
							-webkit-text-size-adjust: 100%;
							-ms-text-size-adjust: 100%;
						}

						table,
						td {
							mso-table-lspace: 0pt;
							mso-table-rspace: 0pt;
						}

						img {
							-ms-interpolation-mode: bicubic;
						}

						img {
							border: 0;
							height: auto;
							line-height: 100%;
							outline: none;
							text-decoration: none;
						}

						table {
							border-collapse: collapse !important;
						}

						body {
							height: 100% !important;
							margin: 0 !important;
							padding: 0 !important;
							width: 100% !important;
						}

						a[x-apple-data-detectors] {
							color: inherit !important;
							text-decoration: none !important;
							font-size: inherit !important;
							font-family: inherit !important;
							font-weight: inherit !important;
							line-height: inherit !important;
						}

						a {
							color: #1cc3b2;
							text-decoration: underline;
						}

						* img[tabindex=0]+div {
							display: none !important;
						}

						@media screen and (max-width:350px) {
							h1 {
								font-size: 24px !important;
								line-height: 24px !important;
							}
						}

						div[style*=margin: 16px 0;

						] {
							margin: 0 !important;
						}

						@media screen and (min-width: 360px) {
							.headingMobile {
								font-size: 40px !important;
							}

							.headingMobileSmall {
								font-size: 28px !important;
							}
						}
					</style>
				</head>

				<body bgcolor="#ffffff" style="background-color: #ffffff; margin: 0 !important; padding: 0 !important;">
					<div
						style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
						to finish signing up, you just need to confirm that we got your e-mail right within 48 hours. To confirm please
						click the VERIFY EMAIL ADDRESS button.</div>
					<center>
						<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" valign="top">
							<tbody>
								<tr>
									<td>
										<table border="0" cellpadding="0" cellspacing="0" align="center" valign="top" bgcolor="#ffffff"
											style="padding: 0 20px !important;max-width: 500px;width: 90%;">
											<tbody>
												<tr>
													<td bgcolor="#ffffff" align="center" style="padding: 10px 0 0px 0;">
														<!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="350">
												<tr>
												<td align="center" valign="top" width="350">
												<![endif]-->
														<table border="0" cellpadding="0" cellspacing="0" width="100%"
															style="max-width: 500px;border-bottom: 1px solid #e4e4e4 ;">
															<tbody>
																<tr>
																	<td bgcolor="#ffffff" align="left" valign="middle"
																		style="padding: 0px; color: #111111; font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; line-height: 62px;padding:0 0 15px 0;">
																		<!-- LOGO
																		<a href="javascript:void(0)" target="_blank"><img width="19" height="25"
																					alt="logo" src=""></a> -->
																	</td>
																	<td bgcolor="#ffffff" align="right" valign="middle"
																		style="padding: 0px; color: #111111; font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; line-height: 48px;padding:0 0 15px 0;">
																		<a href="' . $domain . 'login.php" target="_blank"
																			style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;color: #797979;font-size: 12px;font-weight:400;-webkit-font-smoothing:antialiased;text-decoration: none;">Login
																			to BUCTE</a></td>
																</tr>
															</tbody>
														</table>
														<!--[if (gte mso 9)|(IE)]></td></tr></table>
												<![endif]-->
													</td>
												</tr>
												<tr>
													<td bgcolor="#ffffff" align="center" style="padding: 0;">
														<!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="350">
												<tr>
												<td align="center" valign="top" width="350">
												<![endif]-->
														<table border="0" cellpadding="0" cellspacing="0" width="100%"
															style="max-width: 500px;border-bottom: 1px solid #e4e4e4;">
															<tbody>
																<tr>
																	<td bgcolor="#ffffff" align="left"
																		style="padding: 20px 0 0 0; color: #666666; font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400;-webkit-font-smoothing:antialiased;">
																		<p class="headingMobile"
																			style="margin: 0;color: #171717;font-size: 26px;font-weight: 200;line-height: 130%;margin-bottom:5px;">
																			Thank you for attending {EVENT}.</p>
																	</td>
																</tr>
																<tr>
																	<td height="20"></td>
																</tr>
																<tr>
																	<td bgcolor="#ffffff" align="left"
																		style="padding:0; color: #666666; font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400;-webkit-font-smoothing:antialiased;">
																		<p
																			style="margin:0;color:#585858;font-size:18px;font-weight:bold;line-height:170%;">
																			We hope you enjoyed the event as much as we do.</p>

																		<!-- <p style="margin:0;color:#585858;font-size:14px;font-weight:400;line-height:170%;">
																			We hope you enjoyed the event as much as we do.</p> -->
																		<p style="margin:0;margin-top:20px;line-height:0;"></p>
																		<p
																			style="margin:0;color:#585858;font-size:14px;font-weight:400;line-height:170%;">
																			We are always seeking new ways to make our events and
																			seminars the best they can be. Would you take a minute to
																			give us a feedback?</p>
																	</td>
																</tr>
																<tr>
																	<td align="center">
																		<table width="100%" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td align="center" style="padding: 33px 0 33px 0;">
																					<table border="0" cellspacing="0" cellpadding="0"
																						width="100%">
																						<tr>
																							<td align="center"
																								style="border-radius: 4px;"
																								bgcolor="#1cc3b2"><a
																									href="' . $verification_link . '"
																									style="text-transform:uppercase;background:#1cc3b2;font-size: 13px; font-weight: 700; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none !important; padding: 20px 25px; border-radius: 4px; border: 1px solid #1cc3b2; display: block;-webkit-font-smoothing:antialiased;"
																									target="_blank"><span
																										style="color: #ffffff;text-decoration: none;">Take
																										Survey</span></a>
																							</td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td bgcolor="#ffffff" align="left"
																		style="padding:0; color: #666666; font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400;-webkit-font-smoothing:antialiased;">
																		<!-- <p
																			style="margin:0;color:#585858;font-size:14px;font-weight:400;line-height:170%;">
																			If you did not create an account, no further action is
																			required.</p>
																		<p style="margin:0;margin-top:20px;line-height:0;"></p> -->
																		<p
																			style="margin:0;color:#585858;font-size:14px;font-weight:400;line-height:170%;">
																			Thank you for your time. We appreciate it!<br>Bicol
																			University Center for Teaching Excellence
																		</p>
																	</td>
																</tr>
															</tbody>
														</table>
														<!--[if (gte mso 9)|(IE)]></td></tr></table>
												<![endif]-->
													</td>
												</tr>
												<tr>
													<td bgcolor="#ffffff" align="center" style="padding: 0;">
														<!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="350">
												<tr>
												<td align="center" valign="top" width="350">
												<![endif]-->
														<table border="0" cellpadding="0" cellspacing="0" width="100%"
															style="max-width: 500px;">
															<tbody>
																<tr>
																	<td bgcolor="#ffffff" align="center"
																		style="padding: 30px 0 30px 0; color: #666666; font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 18px;">
																		<p
																			style="margin: 0;color: #585858;font-size: 12px;font-weight: 400;-webkit-font-smoothing:antialiased;line-height: 170%;">
																			Need help? Ask at <a href="mailto:bu-cte@bicol-u.edu.ph"
																				style="color: #1cc3b2;text-decoration: underline;"
																				target="_blank">bu-cte@bicol-u.edu.ph</a>
																<tr>
																	<td bgcolor="#ffffff" align="center"
																		style="padding: 0; color: #666666; font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 18px;">
																		<p
																			style="margin: 0;color: #585858;font-size: 12px;font-weight: 400;-webkit-font-smoothing:antialiased;line-height: 170%;">
																		</p>
																	</td>
																</tr>
																<tr>
																	<td bgcolor="#ffffff" align="center"
																		style="padding: 15px 0 30px 0; color: #666666; font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 18px;">
																		<!-- Avocode, Inc.<br> 330 East 59th Street, 7th Floor<br> New York, NY 10022, USA -->
																		<p
																			style="margin: 0;color: #585858;font-size: 12px;font-weight: 400;-webkit-font-smoothing:antialiased;line-height: 170%;">
																			HERRC Bldg<br>Bicol University East Campus<br>Legazpi City,
																			4500 Albay,
																			Philippines</p>
																	</td>
																</tr>
													</td>
												</tr>
											</tbody>
										</table>
										<!--[if (gte mso 9)|(IE)]></td></tr></table>
						<![endif]-->
									</td>
								</tr>
							</tbody>
						</table>
						</td>
						</tr>
						</tbody>
						</table>
					</center>
				</body>

			</html>
			';

		$mail->send();
		return 'sent';
	} catch (Exception $e) {
		return 'err:mailer';
		// echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}
