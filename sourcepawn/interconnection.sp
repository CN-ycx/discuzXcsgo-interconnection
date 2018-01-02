#pragma semicolon 1
#pragma newdecls required

Database g_hDB;
char TABLE_PREFIX[16] = "discuz_";

// todo:
// Use MySQL struct to call. easy to use sql.

public Plugin myinfo = 
{
    name        = "Discuz X CSGO - Interconnection",
    author      = "Kyle",
    description = "Post Thead to Forum",
    version     = "0.1",
    url         = "https://ump45.moe"
};

public APLRes AskPluginLoad2(Handle myself, bool late, char[] error, int err_max)
{
    CreateNative("DXCI_SetTablePrefix", Native_SetTPrefix);
    CreateNative("DXCI_PostThread",     Native_PostThread);

    RegPluginLibrary("interconnection");

    return APLRes_Success;
}

public void OnPluginStart()
{
    Database.Connect(OnDatabaseConnected, "discuz");
}

public void OnDatabaseConnected(Database db, const char[] error, any data)
{
    if(db == null)
        SetFailState("connect to database failed! -> %s", error);

    g_hDB = db;
    g_hDB.SetCharset("utf8");
    PrintToServer("Database Connected!");
}

public int Native_SetTPrefix(Handle plugin, int numParams)
{
    return (GetNativeString(1, TABLE_PREFIX, 16) == SP_ERROR_NONE);
}

public int Native_PostThread(Handle plugin, int numParams)
{
    int client = GetNativeCell(1); // if 0 will use loop callback
    int uid = GetNativeCell(2);
    char username[32];
    GetNativeString(3, username, 32);
    int fid = GetNativeCell(4); // get filed id
    char subject[128];
    GetNativeString(5, subject, 128);
    char message[512];
    GetNativeString(6, message, 512);

    DataPack pack = new DataPack();
    pack.WriteCell(client);
    pack.WriteCell(uid);
    pack.WriteString(username);
    pack.WriteCell(fid);
    pack.WriteString(subject);
    pack.WriteString(message);
    pack.WriteCell(plugin);
    pack.WriteFunction(GetNativeFunction(7));

    char escUsr[64];
    g_hDB.Escape(username, escUsr, 64);
    
    char escSub[256];
    g_hDB.Escape(subject, escSub, 256);

    char m_szQuery[1024];
    FormatEx(m_szQuery, 1024, "INSERT INTO `%s_forum_thread` \
                               (`fid`, `author`, `authorid`, `subject`, `dateline`, `lastpost`, `lastposter`) \
                               VALUES \
                               (%d, '%s', %d, '%s', %d, %d, '%s');",
                               TABLE_PREFIX,
                               fid,
                               escUsr,
                               uid,
                               escSub,
                               GetTime(),
                               GetTime(),
                               escUsr
                               );
    g_hDB.Query(SQL_InsertThreadId, m_szQuery, pack, DBPrio_High);
}

public void SQL_InsertThreadId(Database db, DBResultSet results, const char[] error, DataPack pack)
{
    pack.Reset();
    int client = pack.ReadCell();
    int uid = pack.ReadCell();
    char username[32];
    pack.ReadString(username, 32);
    int fid = pack.ReadCell();
    char subject[128];
    pack.ReadString(subject, 128);
    char message[512];
    pack.ReadString(message, 512);
    Handle plugin = view_as<Handle>(pack.ReadCell());
    Function callback = pack.ReadFunction();

    if(db == null || error[0])
    {
        LogError("SQL_InsertThreadId -> %s", error);
        LogError("SQL_InsertThreadId -> %N -> %d[%s] -> %d -> %s -> %s", client, uid, username, fid, subject, message);
        CallFunc(plugin, callback, client, uid, username, fid, subject, message, 0, 0, false);
        delete pack;
        return;
    }
    
    int tid = results.InsertId;
    pack.WriteCell(tid);
    
    char m_szQuery[128];
    FormatEx(m_szQuery, 128, "INSERT INTO `%s_forum_post_tableid` VALUES (DEFAULT);", TABLE_PREFIX);
    g_hDB.Query(SQL_InsertTableId, m_szQuery, pack, DBPrio_High);
}

public void SQL_InsertTableId(Database db, DBResultSet results, const char[] error, DataPack pack)
{
    pack.Reset();
    int client = pack.ReadCell();
    int uid = pack.ReadCell();
    char username[32];
    pack.ReadString(username, 32);
    int fid = pack.ReadCell();
    char subject[128];
    pack.ReadString(subject, 128);
    char message[512];
    pack.ReadString(message, 512);
    Handle plugin = view_as<Handle>(pack.ReadCell());
    Function callback = pack.ReadFunction();
    int tid = pack.ReadCell();
    
    if(db == null || error[0])
    {
        LogError("SQL_InsertTableId -> %s", error);
        LogError("SQL_InsertTableId -> %N -> %d[%s] -> %d -> %s -> %s -> %d", client, uid, username, fid, subject, message, tid);
        CallFunc(plugin, callback, client, uid, username, fid, subject, message, tid, 0, false);
        delete pack;
        return;
    }
    
    int pid = results.InsertId;
    pack.WriteCell(pid);
    
    char escUsr[64];
    g_hDB.Escape(username, escUsr, 64);
    
    char escSub[256];
    g_hDB.Escape(subject, escSub, 256);
    
    char escMsg[256];
    g_hDB.Escape(message, escMsg, 1024);
    
    char escIp[32];
    if(client && IsClientConnected(client)) GetClientIP(client, escIp, 32); else strcopy(escIp, 32, "127.0.0.1");

    char m_szQuery[2048];
    FormatEx(m_szQuery, 2048,  "INSERT INTO `%s_forum_post` \
                                (`pid`, `fid`, `tid`, `first`, `author`, `authorid`, `subject`, `dateline`, `message`, `useip`, `position`) \
                                VALUES \
                                (%d, %d, %d, 1, '%s', %d, '%s', %d, '%s', '%s', DEFAULT);", 
                                TABLE_PREFIX,
                                pid,
                                fid,
                                tid,
                                escUsr,
                                uid,
                                escSub,
                                GetTime(),
                                escMsg,
                                escIp);
    g_hDB.Query(SQL_InsertPost, m_szQuery, pack, DBPrio_High);
}

public void SQL_InsertPost(Database db, DBResultSet results, const char[] error, DataPack pack)
{
    pack.Reset();
    int client = pack.ReadCell();
    int uid = pack.ReadCell();
    char username[32];
    pack.ReadString(username, 32);
    int fid = pack.ReadCell();
    char subject[128];
    pack.ReadString(subject, 128);
    char message[512];
    pack.ReadString(message, 512);
    Handle plugin = view_as<Handle>(pack.ReadCell());
    Function callback = pack.ReadFunction();
    int tid = pack.ReadCell();
    int pid = pack.ReadCell();
    
    if(db == null || error[0])
    {
        LogError("SQL_InsertPost -> %s", error);
        LogError("SQL_InsertPost -> %N -> %d[%s] -> %d -> %s -> %s -> %d -> %d", client, uid, username, fid, subject, message, tid, pid);
        CallFunc(plugin, callback, client, uid, username, fid, subject, message, tid, pid, false);
        delete pack;
        return;
    }

    char lastPost[256];
    // !!!!!DONT EDIT THIS!!!!!
    FormatEx(lastPost, 256, "%d	%s	%d	%s", tid, subject, GetTime(), username);
    
    char escPst[512];
    g_hDB.Escape(lastPost, escPst, 512);
    
    char m_szQuery[1024];
    FormatEx(m_szQuery, 1024, "UPDATE `%s_forum_forum` SET threads=threads+1, posts=posts+1, `lastpost`='%s' WHERE fid=%d", TABLE_PREFIX, escPst, fid);
    g_hDB.Query(SQL_UpdateForum, m_szQuery, pack, DBPrio_High);
}

public void SQL_UpdateForum(Database db, DBResultSet results, const char[] error, DataPack pack)
{
    pack.Reset();
    int client = pack.ReadCell();
    int uid = pack.ReadCell();
    char username[32];
    pack.ReadString(username, 32);
    int fid = pack.ReadCell();
    char subject[128];
    pack.ReadString(subject, 128);
    char message[512];
    pack.ReadString(message, 512);
    Handle plugin = view_as<Handle>(pack.ReadCell());
    Function callback = pack.ReadFunction();
    int tid = pack.ReadCell();
    int pid = pack.ReadCell();
    
    if(db == null || error[0])
    {
        LogError("SQL_UpdateForum -> %s", error);
        LogError("SQL_UpdateForum -> %N -> %d[%s] -> %d -> %s -> %s -> %d -> %d", client, uid, username, fid, subject, message, tid, pid);
        CallFunc(plugin, callback, client, uid, username, fid, subject, message, tid, pid, false);
        delete pack;
        return;
    }
    
    if(results.AffectedRows < 1)
    {
        LogError("SQL_UpdateForum -> AffectedRows = 0");
        LogError("SQL_UpdateForum -> %N -> %d[%s] -> %d -> %s -> %s -> %d -> %d", client, uid, username, fid, subject, message, tid, pid);
    }
    
    char m_szQuery[256];
    FormatEx(m_szQuery, 256, "UPDATE `%s_common_member_count` SET threads=threads+1, posts=posts+1 WHERE uid=%d", TABLE_PREFIX, uid);
    g_hDB.Query(SQL_UpdateUser, m_szQuery, pack, DBPrio_High);
}

public void SQL_UpdateUser(Database db, DBResultSet results, const char[] error, DataPack pack)
{
    pack.Reset();
    int client = pack.ReadCell();
    int uid = pack.ReadCell();
    char username[32];
    pack.ReadString(username, 32);
    int fid = pack.ReadCell();
    char subject[128];
    pack.ReadString(subject, 128);
    char message[512];
    pack.ReadString(message, 512);
    Handle plugin = view_as<Handle>(pack.ReadCell());
    Function callback = pack.ReadFunction();
    int tid = pack.ReadCell();
    int pid = pack.ReadCell();
    
    if(db == null || error[0])
    {
        LogError("SQL_UpdateUser -> %s", error);
        LogError("SQL_UpdateUser -> %N -> %d[%s] -> %d -> %s -> %s -> %d -> %d", client, uid, username, fid, subject, message, tid, pid);
        CallFunc(plugin, callback, client, uid, username, fid, subject, message, tid, pid, false);
        delete pack;
        return;
    }

    if(results.AffectedRows < 1)
    {
        LogError("SQL_UpdateUser -> AffectedRows = 0");
        LogError("SQL_UpdateUser -> %N -> %d[%s] -> %d -> %s -> %s -> %d -> %d", client, uid, username, fid, subject, message, tid, pid);
    }

    CallFunc(plugin, callback, client, uid, username, fid, subject, message, tid, pid, true);

    delete pack;
}

void CallFunc(Handle plugin, Function callback, int client, int uid, const char[] username, int fid, const char[] subject, const char[] message, int tid, int pid, bool success)
{
    Call_StartFunction(plugin, callback);
    Call_PushCell(client);
    Call_PushCell(uid);
    Call_PushString(username);
    Call_PushCell(fid);
    Call_PushString(subject);
    Call_PushString(message);
    Call_PushCell(tid);
    Call_PushCell(pid);
    Call_PushCell(success);
    Call_Finish();
}
