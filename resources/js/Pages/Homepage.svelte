<script>
    import {Link, page, useForm} from "@inertiajs/svelte";
    import axios from "axios";
    import FileUploadModal from "@/Components/FileUploadModal.svelte";
    import ChatAssignBoardModal from "@/Components/ChatAssignBoardModal.svelte";

    let StandardChatStart = [{
        role: "system", content: `You are an AI that helps students with formulating questions in a classroom environment. When the user asks you
    a question, you may not answer. Instead you review the question and give strict feedback. Make sure to follow instructions from the system.
    You can also ask the user to provide more context if you need it. Make sure your replies are in the same language as that of the user.
    [Example 1] user: "I am unable to understand the reason this teacher gave me a failing grade on this assignment." assistant: "You should formulate a question where you ask about your grade and what went wrong. 1. make sure to be respectfull. 2. make sure to mentiont what you think you did correctly and ask about why that wasn't enough."`
    },
        {role: "assistant", content: "Hoi, ik ben hier om je te helpen met stellen van vragen!"}]
    export let chatHistory = StandardChatStart, chatList = [], boards =[];
    console.log(chatHistory)


    let chatHistoryID // @hmr:keep
    let fileModal = false, input = "";
    let sidebarOpen = false;

    const generateChat = async () => {
        let oldHistory = chatHistory
        let SendHistory = oldHistory.map((ent)=>{
            console.log(ent)
            return {
                role: ent.role,
                content: ent.content
            }
        })
        SendHistory = [...SendHistory, {role: "user", content: input}]
        chatHistory = [...chatHistory, {role: "user", content: "Loading... Please wait"}]
        console.log(SendHistory)
        //verstuur request
        axios.post("/ChatLLM", {
            chat: input,
            chatHistoryID: chatHistoryID || undefined,
            history: SendHistory,
        })
            .then((res) => {
                if (res.data.chatID) {
                    if (chatHistoryID === undefined) {
                        chatHistoryID = res.data.chatID
                    }
                }
                chatHistory = [...oldHistory, {id: res.data.nceID, role: "user", content: input}, {role: 'assistant', content: res.data.response}]
                console.log(res)
                input = ""
            })
    }

    const logout = async () => {
        try {
            // Verstuur een POST-verzoek naar de logout route
            await axios.post('/logout');
            // Na succesvolle logout, redirect naar de login pagina
            window.location.href = '/login';
        } catch (error) {
            console.error('Error during logout:', error);
        }
    }

    let files;

    $: if (files) {
        console.log(files);

        for (const file of files) {
            console.log(`${file.name}: ${file.size} bytes`);
        }
    }

    let chatEntryID, CEModal = false, CEText="";

    function CloseCEModal() {
        CEModal = false
    }

</script>

<style>
    .speech-bubble-ai {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: auto;
        padding: 10px;
        background-color: #e5e5e5;
        color: black;
        border-radius: 10px;
    }

    .speech-bubble-ai:after {
        content: '';
        /*position: absolute;*/
        width: 0;
        height: 0;
        border: 11px solid transparent;
        background-color: #e5e5e5;
        border-right: 0;
        border-top: 0;
        margin-top: -5.5px;
        margin-right: -11px;
    }


    .speech-bubble-user {
        display: flex;
        align-items: flex-start;
        width: auto;
        padding: 10px;
        background-color: #a2e4ff;
        color: black;
        border-radius: 10px;
        /*position: relative;*/
    }

    .speech-bubble-user:after {
        content: '';
        /*position: absolute;*/
        right: 0;
        top: 50%;
        width: 0;
        height: 0;
        border: 11px solid transparent;
        background-color: #a2e4ff;
        border-right: 0;
        border-top: 0;
        margin-top: -5.5px;
        margin-right: -11px;
    }

    .custom-circle::before {
        content: '';
        display: inline-block;
        width: 2.5rem; /* 10 * 0.25rem */
        height: 2.5rem;
        background-image: url('../../img/login.png');
        background-size: cover;
        background-position: center;
        border-radius: 50%;
        margin-right: 0.625rem; /* 2.5 * 0.25rem */
        background-color: white; /* Fallback in case the image doesn't load */
    }
</style>

{#if fileModal}
    <FileUploadModal bind:modal={fileModal} bind:chatHistory={chatHistory} bind:chatHistoryID={chatHistoryID}
                     bind:files={files}>
    </FileUploadModal>
{/if}

{#if CEModal}
    <ChatAssignBoardModal modalClose={CloseCEModal} bind:ChatID={chatEntryID} bind:CEPreview={CEText} boards={boards}></ChatAssignBoardModal>
{/if}

<div class="overflow-hidden h-screen">
    <div class="flex">
        <section class={`border bg-[#398DA9] w-max w-4/6 md:w-1/6 flex items-center flex-col h-screen overflow-auto transform transition-transform ${sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'} ${'absolute md:relative'}`}>
            <button type="button" class="text-black text-4xl md:hidden mr-auto mt-2" style="width: 3.5rem; height: 3.5rem;"
                    on:click={() => sidebarOpen = false}>
                ☰
            </button>
            <div class="flex-col flex items-center mb-5">
                <div class="text-center">
                    <p class="text-2xl">Chatgeschiedenis</p>
                </div>

                {#each chatList as chat}
                    <div class="bg-[#F4FFFE] flex m-4 text-xl rounded-md">
                        <button on:click={()=>{
            chatHistoryID = chat.id
            axios.get('/getHistory/'+chatHistoryID)
            .then((res)=>{
                console.log(res.data)
                chatHistory = res.data.map((chat)=>({id:chat.id, role:chat.Sender, content:chat.Content}));
                chatHistory = [...StandardChatStart, ...chatHistory]
            })
        }
        }>
                            {chat.ChatTitle}
                        </button>

                        <button class="bg-red-500" on:click={()=>{
                        axios.delete(`/delChat/${chat.id}`)
                        .then((res)=>{
                            console.log(res)
                            chatList = res.data
                        })
                    }}>
                            X
                        </button>

                    </div>

                {/each}
                <button class="bg-gold w-24 text-xl rounded-md" on:click={()=>{
                chatHistoryID = undefined
                chatHistory = StandardChatStart
            }}>+
                </button>
            </div>
            <div class="w-full">
                <div class="w-full border mb-5"></div>
                <div class="w-full mb-3">
                    <Link href="/digibord" class="w-full flex justify-center">
                        <button class="bg-[#F4FFFE] hover:bg-blue-400 rounded-md p-1 w-11/12">Bekijk vraagborden
                        </button>
                    </Link>
                </div>
            </div>
        </section>

        <div class="flex flex-col justify-between h-screen w-screen bg-[#F4FFFE] overflow-auto">
            <div class="">
                <!--Header-->
                <header
                    class="header bg-[#40A0C1] text-white w-full flex justify-between md:justify-end items-center">
                    <button
                        type="button"
                        class="text-black text-4xl md:hidden mb-1"
                        style="width: 3.5rem; height: 3.5rem;"
                        on:click={() => sidebarOpen = !sidebarOpen}
                    >
                        ☰
                    </button>
                    <button
                        class="black-circle relative custom-circle"
                        on:click={logout}
                        title="Klik om uit te loggen"
                        aria-label="Uitloggen">
                    </button>
                </header>
            </div>

            <!--Chat-->
            <section
                class="flex flex-col overflow-auto items-center align-middle h-full font-sans font-sans text-lg">

                {#each chatHistory as chat}
                    {#if chat.role === "user"}
                        <div class="mb-2 w-11/12 flex justify-end">
                            <div class="w-2/3 flex justify-end">
                                <div class="speech-bubble-user flex-row">
                                    <button class="bg-gray-700 w-5 hover:bg-gray-500 text-white font-bold" on:click={()=>{
                                        chatEntryID = chat.id
                                        CEText = chat.content
                                        CEModal = true
                                    }}>↑</button><span>{chat.content}</span>
                                </div>
                            </div>

                        </div>

                    {:else if chat.role === "assistant"}
                        <div class="mb-2 w-11/12 flex justify-start">
                            <div class="w-2/3 flex justify-start">
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

                        <button type="button" on:click|preventDefault={()=>{
                            fileModal = true;
                        }}
                                class="bg-white border border-gray-300 text-white text-sm rounded-l-full p-2 pl-3 cursor-pointer"
                                style="width: 3.5rem; height: 2.35rem; border-right: none;">
                            <span style="font-size: 1.5rem;">🔗</span>
                        </button>

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
