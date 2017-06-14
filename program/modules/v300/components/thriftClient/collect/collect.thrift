/**
 * Collect服务接口文件
 *
 * 创建人：李冬冬
 *
 * 2016-3-21
 */

namespace php components.thriftClient.collect
struct CollectList {
  1: i32 rootid,
  2: i32 mainid,
  3: string name,
  4: string pic,
  5: string detailurl,
  6: string collecttime,
}

service Collect {
  list<CollectList> getCollectList(1:i32 userid),
  bool collectAdd(1:i32 userid, 2:i32 rootid, 3:i32 mainid),
  bool collectRemove(1:i32 userid, 2:i32 rootid, 3:i32 mainid),
}