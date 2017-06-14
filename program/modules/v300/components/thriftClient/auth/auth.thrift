/**
 * Auth服务接口文件
 *
 * 创建人：李红天
 *
 * 2017-5-16
 */

namespace php components.thriftClient.auth

struct UserInfo {
  1: i32 userid,
  2: string token,
  3: i32 status,
  4: bool valid_ip,
  5: string local,
  6: i32 timezone_offset,
  7: i32 token_expire,
}

exception TokenExpireException {
  1: string result,
  2: string error,
  3: string content,
}

service Auth {
  UserInfo login(1:string mac, 2:string version, 3:string language, 4:string userip),
}