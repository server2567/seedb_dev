<?php
class Service_ldap {
        private $CI;            /*!< CodeIgniter instance */
        protected $connection = NULL;

        private $host;
        private $port;
        private $account_prefix;
		function __construct() {
                $this->CI = & get_instance();
				$this->CI->config->load('ldap_config',TRUE);
				$this->host = $this->CI->config->item('host','ldap_config');
				$this->port = $this->CI->config->item('port','ldap_config');
				$this->account_prefix = $this->CI->config->item('account_prefix','ldap_config');
				return $this->connect();
        }

        function __destruct() {
                $this->close();
        }

        /**
         * Connect to LDAP server
         */
        public function connect() {
                try {
                        $this->connection = @ldap_connect( $this->host, $this->ldap_port );
                        if( !$this->connection ) {
                                return false;
                        }
                }catch (Exception $e) {									
					return false;
                }
                return true;
        }

        /**
         * Authenticate to LDAP with username and password
         * @param $username
         * @param $password
         */
        public function authenticate( $us_username, $us_password ) {
                try {
                        if( $this->connection ) {
								$bind = @ldap_bind($this->connection, $this->account_prefix.$us_username, $us_password);
								if( $bind ) {
                                        /** TODO **/
                                } else {
                                        return false;
                                }
                        } else {
                                return false;
                        }
                } catch( Exception $e ) {
                        return false;
                }
                return true;
        }

        /**
         * Close LDAP connection
         */
        public function close() {
                try {
                        if( $this->connection ) {
                                @ldap_close($this->connection);
                        } else {
                                return false;
                        }
                } catch( Exception $e ) {
                        return false;
                }
                return true;
        }
}
?>