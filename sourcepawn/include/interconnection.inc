#if defined _interconnection_INCLUDED
    #endinput
#endif

#define _interconnection_INCLUDED

public SharedPlugin __pl_interconnection = 
{
	name = "interconnection",
	file = "interconnection.smx",
#if defined REQUIRE_PLUGIN
	required = 1
#else
	required = 0
#endif
};

//URL EXAMPLE -> https://YOUR.WEBSITE.HOST/YOUR/PATH/TO/FORUM/forum.php?mod=redirect&goto=findpost&ptid={tid}&pid={pid}
// if tid or pid is 0, check errorlogs. this callback is always called.
typedef PostThreadCallback = function void (int client, int uid, const char[] username, int fid, const char[] subject, const char[] message, int tid, int pid, bool fullySuccess);

native bool DXCI_SetTablePrefix(const char[] prefix);

// if client is 0, we will use loop callback IP.
native void DXCI_PostThread(int client, int uid, const char[] username, int fieldId, const char[] subject, const char[] message, PostThreadCallback callback);