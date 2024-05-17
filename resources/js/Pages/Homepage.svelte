<script>
    import {page, useForm} from "@inertiajs/svelte";
    import axios from "axios";

    let StandardChatStart = [{role: "system", content: `You are an AI that helps students with formulating questions in a classroom environment. When the user asks you
    a question, you may not answer. Instead you review the question and give strict feedback.
    You can also ask the user to provide more context if you need it. Make sure your replies are in the same language as that of the user.
    [Example 1] user: "I am unable to understand the reason this teacher gave me a failing grade on this assignment." assistant: "You should formulate a question where you ask about your grade and what went wrong. 1. make sure to be respectfull. 2. make sure to mentiont what you think you did correctly and ask about why that wasn't enough."`},
        {role: "assistant", content: "Hoi, ik ben hier om je te helpen met stellen van vragen!"}]
    export let chatHistory = StandardChatStart, chatList = [];

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
                    if(chatHistoryID === undefined)
                    {

                    }
                    chatHistoryID = res.data.chatID
                }
                chatHistory = [...chatHistory, {role: 'assistant', content: res.data.response}]
                console.log(res)
                input = ""
            })
    }

    let files;

    $: if (files) {
        console.log(files);

        for (const file of files) {
            console.log(`${file.name}: ${file.size} bytes`);
        }
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
        right: 0;
        top: 50%;
        width: 0;
        height: 0;
        border: 11px solid transparent;
        border-left-color: #3b82f6;
        border-right: 0;
        border-top: 0;
        margin-top: -5.5px;
        margin-right: -11px;
    }

</style>


<div class="overflow-hidden h-screen">
    <div class="flex">
        <section class="border bg-[#398DA9] w-1/6 flex items-center flex-col h-screen overflow-auto">
            <div class="text-center">
                <p class="text-2xl">Chatgeschiedenis</p>
            </div>

            {#each chatList as chat}
                <button class="bg-[#F4FFFE] m-4 text-xl rounded-md" on:click={()=>{
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
            <button class="bg-gold w-24 text-xl rounded-md" on:click={()=>{
                chatHistoryID = 0
                chatHistory = StandardChatStart
            }}>+</button>

        </section>

        <div class="flex flex-col justify-between w-5/6">
            <!--Header-->
            <header
                class="header bg-[#40A0C1] text-white w-full h-12 flex justify-between items-center">
                <div
                    class="logo relative before:content-[''] before:inline-block before:w-10 before:h-10 before:bg-white before:rounded-full before:ml-2.5"></div>
                <div
                    class="black-circle relative before:content-[''] before:inline-block before:w-10 before:h-10 before:bg-black before:rounded-full before:mr-2.5"></div>
            </header>

            <!--Chat-->
            <section class="flex flex-col items-center align-middle h-fit justify-center font-sans bg-[#F4FFFE] font-sans text-lg">

                {#each chatHistory as chat}
                    {#if chat.role === "user"}
                        <div class="mb-2 w-2/3 flex justify-end">
                            <div class="w-2/3">
                                <div class="speech-bubble-user ">
                                    {chat.content}
                                </div>
                            </div>

                        </div>

                    {:else if chat.role === "assistant"}
                        <div class="mb-2 w-2/3 flex justify-start">
                            <div class="w-2/3">
                                <div class="speech-bubble-ai">
                                    {chat.content}
                                </div>
                            </div>

                        </div>
                    {/if}
                {/each}
            </section>

            <!--Chat Input-->
            <section class="flex flex-col justify-between w-full">

                <div class="container mx-auto flex justify-end h-20">
                    <form on:submit|preventDefault={generateChat}
                          class="bg-[#40A0C1] flex items-center border border-gray-300 p-2 w-full">
                        <input class="hidden" bind:files id="many" multiple type="file" accept="application/msword,application/pdf"/>

                        <label for="many" class="bg-white border border-gray-300 text-white text-sm rounded-l-full p-2 pl-3 cursor-pointer"
                               style="width: 3.5rem; height: 2.35rem; border-right: none;">
                            <span style="font-size: 1.5rem;">🔗</span>
                        </label>

                        <!--{#if files}-->
                        <!--    <h2>Selected files:</h2>-->
                        <!--    {#each Array.from(files) as file}-->
                        <!--        <p>{file.name} ({file.size} bytes)</p>-->
                        <!--    {/each}-->
                        <!--{/if}-->
                        <input
                            class="bg-white border border-gray-300 w-11/12 text-black text-sm rounded-r-full focus:ring-blue-500 focus:border-blue-500 p-2"
                            type="text"
                            style="border-left: none;"
                            id="prompt"
                            bind:value={input}
                            placeholder="Typ uw bericht hier..."
                        />
                        <button
                            type="submit"
                            class="bg-white text-2xl rounded-full p-2 ml-4"
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
