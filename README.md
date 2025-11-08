# CodeIgniter Voting System

## Installation Instructions for VPS Ubuntu 22

1. **Install PHP and required extensions:**
    ```bash
    sudo apt update
    sudo apt install php php-xml php-mbstring php-curl php-zip
    ```
2. **Install Composer:**
    ```bash
    sudo apt install composer
    ```
3. **Clone the repository:**
    ```bash
    git clone https://github.com/hajitazu/pilketos36.git
    cd pilketos36
    ```
4. **Install dependencies:**
    ```bash
    composer install
    ```
5. **Set up your `.env` file:**
    ```bash
    cp .env.example .env
    nano .env
    ```
6. **Generate application key:**
    ```bash
    php spark key:generate
    ```
7. **Run migrations (if any):**
    ```bash
    php spark migrate
    ```
8. **Start the server:**
    ```bash
    php spark serve
    ```
9. **Access the application:**
    Open your web browser and visit `http://localhost:8080`.