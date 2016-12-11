<?php
namespace API;

const DEBUG = true;

const PROJECT_ROOT = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR;
const API_ROOT = PROJECT_ROOT . 'API' . DIRECTORY_SEPARATOR;
const PUBLIC_ROOT = PROJECT_ROOT . 'public' . DIRECTORY_SEPARATOR;

// permission system
const USER_ROLE_USERMESSAGE = 1;
const USER_ROLE_ORDER_OVERVIEW = 2;
const USER_ROLE_ORDER_ADD = 4;
const USER_ROLE_ORDER_MODIFY = 8;
const USER_ROLE_ORDER_MODIFY_PRICE = 16;
const USER_ROLE_ORDER_MODIFY_PRIORITY = 32;
const USER_ROLE_ORDER_CANCEL = 64;
const USER_ROLE_INVOICE_OVERVIEW = 128;
const USER_ROLE_INVOICE_ADD = 256;
const USER_ROLE_INVOICE_CANCEL = 512;
const USER_ROLE_INVOICE_CUSTOMER_OVERVIEW = 1024;
const USER_ROLE_INVOICE_CUSTOMER_ADD = 2048;
const USER_ROLE_INVOICE_CUSTOMER_MODIFY = 4096;
const USER_ROLE_INVOICE_CUSTOMER_REMOVE = 8192;
const USER_ROLE_PAYMENT_OVERVIEW = 16384;
const USER_ROLE_PAYMENT_ADD = 32768;
const USER_ROLE_PAYMENT_CANCEL = 65536;
const USER_ROLE_PAYMENT_COUPON_OVERVIEW = 131072;
const USER_ROLE_PAYMENT_COUPON_ADD = 262144;
const USER_ROLE_PAYMENT_COUPON_MODIFY = 524288;
const USER_ROLE_PAYMENT_COUPON_CANCEL = 1048576;
const USER_ROLE_MANAGER_OVERVIEW = 2097152;
const USER_ROLE_MANAGER_CALLBACK = 4194304;
const USER_ROLE_MANAGER_CHECK_SPECIAL_ORDER = 8388608;
const USER_ROLE_MANAGER_CHECK_NEW_TABLE = 16777216;
const USER_ROLE_MANAGER_GROUPMESSAGE = 33554432;
const USER_ROLE_MANAGER_SET_AVAILABILITY = 67108864;
const USER_ROLE_MANAGER_STATISTIC = 134217728;
const USER_ROLE_DISTRIBUTION_OVERVIEW = 268435456;
const USER_ROLE_DISTRIBUTION_SET_AVAILABILITY = 536870912;
const USER_ROLE_DISTRIBUTION_PREVIEW = 1073741824; // MAX 32bit processor end!!!

const PAYMENT_TYPE_CASH = 1;
const PAYMENT_TYPE_BANK_TRANSFER = 2;

const ORDER_STATUS_WAITING = 1;
const ORDER_STATUS_IN_PROGRESS = 2;
const ORDER_STATUS_FINISHED = 3;
const ORDER_AVAILABILITY_AVAILABLE = 'AVAILABLE';
const ORDER_AVAILABILITY_DELAYED = 'DELAYED';
const ORDER_AVAILABILITY_OUT_OF_ORDER = 'OUT OF ORDER';

const ORDER_DEFAULT_SIZEID = 1;

const DATE_MYSQL_TIMEFORMAT = "Y-m-d H:i:s";
const DATE_JS_TIMEFORMAT = "dd.MM.yyyy H:mm:ss";
const DATE_JS_DATEFORMAT = "dd.MM.yyyy";
const DATE_PHP_TIMEFORMAT = "d.m.Y H:i:s";
const DATE_PHP_DATEFORMAT = "d.m.Y";

const PRINTER_CHARACTER_EURO = "\x1B\x74\x13\xD5";
const PRINTER_LOGO_DEFAULT = 1;
const PRINTER_LOGO_BIT_IMAGE = 2;
const PRINTER_LOGO_BIT_IMAGE_COLUMN = 3;
const PRINTER_TYPE_NETWORK = 1;
const PRINTER_TYPE_FILE = 2;
const PRINTER_TYPE_WINDOWS = 3;
const PRINTER_TYPE_CUPS = 4;
const PRINTER_TYPE_DUMMY = 5;