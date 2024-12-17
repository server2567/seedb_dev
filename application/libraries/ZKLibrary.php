<?php

declare(strict_types=1);

error_reporting(0);

define('CMD_CONNECT', 1000);
define('CMD_EXIT', 1001);
define('CMD_ENABLEDEVICE', 1002);
define('CMD_DISABLEDEVICE', 1003);
define('CMD_RESTART', 1004);
define('CMD_POWEROFF', 1005);
define('CMD_SLEEP', 1006);
define('CMD_RESUME', 1007);
define('CMD_TEST_TEMP', 1011);
define('CMD_TESTVOICE', 1017);
define('CMD_VERSION', 1100);
define('CMD_CHANGE_SPEED', 1101);

define('CMD_ACK_OK', 2000);
define('CMD_ACK_ERROR', 2001);
define('CMD_ACK_DATA', 2002);
define('CMD_PREPARE_DATA', 1500);
define('CMD_DATA', 1501);

define('CMD_USER_WRQ', 8);
define('CMD_USERTEMP_RRQ', 9);
define('CMD_USERTEMP_WRQ', 10);
define('CMD_OPTIONS_RRQ', 11);
define('CMD_OPTIONS_WRQ', 12);
define('CMD_ATTLOG_RRQ', 13);
define('CMD_CLEAR_DATA', 14);
define('CMD_CLEAR_ATTLOG', 15);
define('CMD_DELETE_USER', 18);
define('CMD_DELETE_USERTEMP', 19);
define('CMD_CLEAR_ADMIN', 20);
define('CMD_ENABLE_CLOCK', 57);
define('CMD_STARTVERIFY', 60);
define('CMD_STARTENROLL', 61);
define('CMD_CANCELCAPTURE', 62);
define('CMD_STATE_RRQ', 64);
define('CMD_WRITE_LCD', 66);
define('CMD_CLEAR_LCD', 67);

define('CMD_GET_TIME', 201);
define('CMD_SET_TIME', 202);

define('USHRT_MAX', 65535);

define('LEVEL_USER', 0);
define('LEVEL_ENROLLER', 2);
define('LEVEL_MANAGER', 12);
define('LEVEL_SUPERMANAGER', 14);

class ZKLibrary
{
    public ?string $ip = null;
    public ?int $port = null;
    public $socket = null;
    public int $session_id = 0;
    public string $received_data = '';
    public array $user_data = [];
    public array $attendance_data = [];
    public int $timeout_sec = 5;
    public int $timeout_usec = 5000000;

    public function __construct(?string $ip = null, ?int $port = null)
    {
        $this->ip = $ip;
        $this->port = $port;
        $this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        $this->setTimeout($this->timeout_sec, $this->timeout_usec);
    }

    public function __destruct()
    {
        unset($this->received_data, $this->user_data, $this->attendance_data);
    }

    public function connect(?string $ip = null, int $port = 4370): bool
    {
        $this->ip = $ip ?? $this->ip;
        $this->port = $port;

        if ($this->ip === null || $this->port === null) {
            return false;
        }

        $command = CMD_CONNECT;
        $command_string = '';
        $chksum = 0;
        $session_id = 0;
        $reply_id = -1 + USHRT_MAX;
        $buf = $this->createHeader($command, $chksum, $session_id, $reply_id, $command_string);

        socket_sendto($this->socket, $buf, strlen($buf), 0, $this->ip, $this->port);

        try {
            socket_recvfrom($this->socket, $this->received_data, 1024, 0, $this->ip, $this->port);
            if (strlen($this->received_data) > 0) {
                $u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6', substr($this->received_data, 0, 8));
                $this->session_id = hexdec($u['h6'] . $u['h5']);
                return $this->checkValid($this->received_data);
            }
            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function disconnect(): bool
    {
        if ($this->ip === null || $this->port === null) {
            return false;
        }

        $command = CMD_EXIT;
        $command_string = '';
        $chksum = 0;
        $session_id = $this->session_id;
        $u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6/H2h7/H2h8', substr($this->received_data, 0, 8));
        $reply_id = hexdec($u['h8'] . $u['h7']);
        $buf = $this->createHeader($command, $chksum, $session_id, $reply_id, $command_string);

        socket_sendto($this->socket, $buf, strlen($buf), 0, $this->ip, $this->port);

        try {
            socket_recvfrom($this->socket, $this->received_data, 1024, 0, $this->ip, $this->port);
            return $this->checkValid($this->received_data);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function setTimeout(int $sec = 0, int $usec = 0): void
    {
        $this->timeout_sec = $sec ?: $this->timeout_sec;
        $this->timeout_usec = $usec ?: $this->timeout_usec;

        $timeout = ['sec' => $this->timeout_sec, 'usec' => $this->timeout_usec];
        socket_set_option($this->socket, SOL_SOCKET, SO_RCVTIMEO, $timeout);
    }

    public function createHeader(int $command, int $chksum, int $session_id, int $reply_id, string $command_string): string
    {
        $buf = pack('SSSS', $command, $chksum, $session_id, $reply_id) . $command_string;
        $buf = unpack('C' . (8 + strlen($command_string)) . 'c', $buf);
        $u = unpack('S', $this->checkSum($buf));
        $chksum = array_values($u)[0] ?? 0;

        $reply_id += 1;
        if ($reply_id >= USHRT_MAX) {
            $reply_id -= USHRT_MAX;
        }
        return pack('SSSS', $command, $chksum, $session_id, $reply_id) . $command_string;
    }

    private function checkSum(array $p): string
    {
        $chksum = array_reduce(
            range(1, count($p), 2),
            fn ($carry, $i) => ($carry + ($p["c$i"] + ($p["c" . ($i + 1)] << 8))) % USHRT_MAX,
            0
        );

        return pack('S', -$chksum - 1 + USHRT_MAX);
    }

    private function checkValid(string $reply): bool
    {
        $u = unpack('H2h1/H2h2', substr($reply, 0, 8));
        $command = hexdec($u['h2'] . $u['h1']);
        return $command === CMD_ACK_OK;
    }

    public function execCommand(int $command, string $command_string = '', int $offset_data = 8): string|bool
    {
        $chksum = 0;
        $session_id = $this->session_id;
        $u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6/H2h7/H2h8', substr($this->received_data, 0, 8));
        $reply_id = hexdec($u['h8'] . $u['h7']);
        $buf = $this->createHeader($command, $chksum, $session_id, $reply_id, $command_string);

        socket_sendto($this->socket, $buf, strlen($buf), 0, $this->ip, $this->port);

        try {
            socket_recvfrom($this->socket, $this->received_data, 1024, 0, $this->ip, $this->port);
            return substr($this->received_data, $offset_data);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function getVersion(): string|bool
    {
        return $this->execCommand(CMD_VERSION);
    }

    public function restartDevice(): string|bool
    {
        return $this->execCommand(CMD_RESTART, chr(0) . chr(0));
    }

    public function shutdownDevice(): string|bool
    {
        return $this->execCommand(CMD_POWEROFF, chr(0) . chr(0));
    }

    public function enableDevice(): string|bool
    {
        return $this->execCommand(CMD_ENABLEDEVICE);
    }

    public function disableDevice(): string|bool
    {
        return $this->execCommand(CMD_DISABLEDEVICE, chr(0) . chr(0));
    }

    public function getTime(): string|bool
    {
        $data = $this->execCommand(CMD_GET_TIME);
        if ($data === false) {
            return false;
        }
        return $this->decodeTime(hexdec(bin2hex($data)));
    }

    public function setTime(string $time): string|bool
    {
        $command_string = pack('I', $this->encodeTime($time));
        return $this->execCommand(CMD_SET_TIME, $command_string);
    }

    public function getAttendance(): array|bool
    {
        if (!$this->execCommand(CMD_ATTLOG_RRQ)) {
            return false;
        }

        $attendances = [];
        while (true) {
            try {
                socket_recvfrom($this->socket, $this->received_data, 1024, 0, $this->ip, $this->port);
                $data = substr($this->received_data, 8);
                if (strlen($data) < 40) {
                    break;
                }
                while (strlen($data) >= 40) {
                    $record = substr($data, 0, 40);
                    $uid = unpack('H*', substr($record, 0, 4))[1];
                    $timestamp = $this->decodeTime(unpack('H*', substr($record, 28, 8))[1]);
                    $attendances[] = ['uid' => $uid, 'timestamp' => $timestamp];
                    $data = substr($data, 40);
                }
            } catch (\Throwable $e) {
                break;
            }
        }

        return $attendances;
    }

    private function decodeTime($data): string
    {
        $second = $data % 60;
        $minute = ($data / 60) % 60;
        $hour = ($data / 3600) % 24;
        $day = ($data / 86400) % 31 + 1;
        $month = ($data / 2678400) % 12 + 1;
        $year = floor($data / 32140800) + 2000;

        return sprintf('%04d-%02d-%02d %02d:%02d:%02d', $year, $month, $day, $hour, $minute, $second);
    }

    private function encodeTime(string $time): int
    {
        $t = strtotime($time);
        return (($t - strtotime('2000-01-01 00:00:00')) * 1000) / 1000;
    }

    public function clearAttendance(): string|bool
    {
        return $this->execCommand(CMD_CLEAR_ATTLOG);
    }

public function ping(int $timeout = 1): string
{
    $start_time = microtime(true);

    $pfile = @fsockopen($this->ip, $this->port, $errno, $errstr, $timeout);
    if (!$pfile) {
        return 'down'; // ?????????????????
    }

    $end_time = microtime(true);
    fclose($pfile);

    $latency = round(($end_time - $start_time) * 1000); // ??????????????????????
    return "{$latency} ms"; // ????????????????
}

    // Add more methods as needed following the same pattern...
}
