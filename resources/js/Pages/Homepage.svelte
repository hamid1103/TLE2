<script>
    import {page, useForm} from "@inertiajs/svelte";
    import axios from "axios";

    export let chatHistory = [], chatList = [];

    let chatHistoryID, input = "";

    const generateChat = async () => {
        chatHistory = [...chatHistory, {role: "user", content: input}]
        //verstuur request
        axios.post("/ChatLLM", {
            chat: input,
            chatHistoryID: chatHistoryID || undefined,
            history: chatHistory,
        })
            .then((res) => {
                if (res.chatID) {
                    chatHistoryID = res.data.chatID
                }
                chatHistory = [...chatHistory, {role: 'assistant', content: res.data.response}]
                console.log(res)
            })
    }

</script>

<style>
    .speech-bubble-ai {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: auto;
        padding: 10px;
        background-color: #3b82f6;
        color: white;
        border-radius: 10px;
    }

    .speech-bubble-ai:after {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        border: 11px solid transparent;
        border-left-color: #3b82f6;
        border-right: 0;
        border-top: 0;
        margin-top: -5.5px;
        margin-right: -11px;
    }


    .speech-bubble-user {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: auto;
        padding: 10px;
        background-color: #3b82f6;
        color: white;
        border-radius: 10px;
        position: relative;
    }

    .speech-bubble-user:after {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 0;
        height: 0;
        border: 11px solid transparent;
        border-right-color: #3b82f6;
        border-left: 0;
        border-top: 0;
        margin-top: -5.5px;
        margin-left: -11px;
    }

</style>


<div class="overflow-hidden h-screen">
    <div class="flex">
        <section class="border bg-blue-300 w-1/4 flex items-center flex-col h-screen overflow-auto">
            <div class="text-center">
                <p class="text-2xl">Chatgeschiedenis</p>
            </div>

            {#each chatList as chat}
                <button class="bg-yellow-100 m-4 text-xl rounded-md" on:click={()=>{
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

        </section>

        <div class="flex flex-col justify-between w-3/4">
            <!--Header-->
            <header
                class="header bg-gray-800 text-white w-full h-12 flex justify-between items-center">
                <div
                    class="logo relative before:content-[''] before:inline-block before:w-10 before:h-10 before:bg-white before:rounded-full before:ml-2.5"></div>
                <div
                    class="black-circle relative before:content-[''] before:inline-block before:w-10 before:h-10 before:bg-black before:rounded-full before:mr-2.5"></div>
            </header>

            <!--Chat-->
            <section class="flex flex-col items-center align-middle h-fit justify-center font-sans bg-white font-sans text-lg">

                {#each chatHistory as chat}
                    {#if chat.role === "user"}
                        <div class="mb-2 w-2/3 flex justify-start">
                            <div class="speech-bubble-user">
                                {chat.content}
                            </div>
                        </div>

                    {:else if chat.role === "assistant"}
                        <div class="mb-2 w-2/3 flex justify-end">
                        <div class="speech-bubble-ai">
                            {chat.content}
                        </div>
                        </div>
                    {/if}
                {/each}
            </section>

            <!--Chat Input-->
            <section class="flex flex-col justify-between w-full">

                <div class="container mx-auto flex justify-end h-20">
                    <form on:submit|preventDefault={generateChat}
                          class="bg-gray-100 flex items-center border border-gray-300 p-2 w-full">
                        <input
                            class="bg-white border border-gray-300 w-11/12 w-1/2 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2  ml-8"
                            type="text"
                            id="prompt"
                            bind:value={input}
                            placeholder="Typ uw bericht hier..."
                        />
                        <button
                            type="submit"
                            class="bg-blue-500 text-white text-sm rounded-full p-2 ml-4"
                            style="width: 3.5rem; height: 3.5rem;"
                        >
                            ➤
                        </button>
                    </form>
                </div>
            </section>

        </div>

    </div>
</div>
