<div
    class="min-h-screen flex flex-col justify-between items-center sm:pt-0 bg-[url('../../public/build/assets/frame_login.png')]">
    <div class="bg-white flex justify-around w-full">
        <img src="build/assets/Logo_pc-tech.jpg" alt="" class="w-[70px] h-auto">
        <img src="build/assets/drapeau_gabon.jpeg" alt="" class="w-[70px] h-auto">
    </div>
    <div class="w-full  flex flex-col justify-center items-center">
        <div class="flex  max-w-[450px] w-full flex-col justify-center items-center">
            <h1 class="text-white font-bold text-[38px] ">Bienvenu à vous</h1>
            <p class="text-white mb-5 text-[16px]">Veuillez vous connecter pour continuer</p>
            <!-- {{ $logo }}  -->
            <img src="build/assets/21-avatar.gif" alt="" class="rounded-full w-[100px] h-auto">

            <div class="w-full mt-6 px-6 py-4  overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
        <div class="bg-white flex justify-center items-center w-full">
            <p class="text-[14px] my-5">Copy right @ 2024 KFC Weighting Station</p>
        </div>
    </div>