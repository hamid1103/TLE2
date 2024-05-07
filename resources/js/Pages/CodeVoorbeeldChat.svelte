<script>
    import {page, useForm} from "@inertiajs/svelte";
    import axios from "axios";

    export let chatHistory = [], chatList=[];

    let chatHistoryID, input="";

    const generateChat = async ()=>{
        chatHistory = [...chatHistory, {role:"user", content: input}]
        //verstuur request
        axios.post("/ChatLLM",{
            chat: input,
            chatHistoryID: chatHistoryID||undefined,
            history: chatHistory,
        })
            .then((res)=>{
                if(res.chatID){
                    chatHistoryID=res.data.chatID
                }
                chatHistory = [...chatHistory, {role:'assistant', content: res.data.response}]
                console.log(res)
            })
    }

</script>

<div class="flex flex-col">
    {#each chatList as chat}
        <button class="bg-black text-gold text-xl rounded min-w-14" on:click={()=>{
            chatHistoryID = chat.id
            axios.get('/getHistory/'+chatHistoryID)
            .then((res)=>{
                console.log(res.data)
                chatHistory = res.data.map((chat)=>({role:chat.Sender,content:chat.Content}));
            })
        }
        }>
            {chat.ChatTitle}
        </button>
    {/each}
</div>

<div class="border bg-gold w-full h-1/2 flex flex-col">
    <!--Elke keer als de array verandert, komt de nieuwe chat erin.-->
    {#each chatHistory as chat}
        <div class="bg-white border-4 w-3/4">
            {chat.role}:{chat.content}
        </div>
    {/each}
</div>

<form on:submit|preventDefault={()=>{
    generateChat()
}}>
    <input class="border-2 text-black" type="text" id="prompt" bind:value={input}>
</form>
