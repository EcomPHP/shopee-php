# Contributing to EcomPHP Shopee PHP SDK

First off, thank you for considering contributing to the **Shopee API PHP SDK**! It's people like you who make the open-source community such an amazing place to learn, inspire, and create.

To ensure a smooth and efficient collaboration, please take a moment to review the following guidelines before getting started.

---

## 📜 Code of Conduct

By participating in this project, you agree to maintain a respectful, welcoming, and professional environment for everyone. Please report any unacceptable behavior to the project maintainers.

---

## 🛠️ How Can I Contribute?

### 1. Reporting Bugs
Before opening a new issue, please search the [Existing Issues](https://github.com/EcomPHP/shopee-php/issues) to see if someone else has already reported it. If not, create a new issue and include:
* A clear and descriptive title.
* Steps to reproduce the problem.
* Expected vs. actual behavior.
* Your environment details (PHP version, OS, Framework if applicable).
* **Do not** share your sensitive credentials (`partner_id`, `partner_key`, or production `access_token`) in public issues!

### 2. Suggesting Enhancements
We welcome ideas for new features or missing Shopee API endpoints! Please open an issue with the tag `enhancement` and describe:
* The core problem this feature solves.
* A brief breakdown of how it should work or look (code snippets are highly appreciated).

### 3. Submitting Pull Requests (PRs)
Ready to write some code? Follow this workflow to get your changes merged:

1. **Fork the Repository:** Fork [EcomPHP/shopee-php](https://github.com/EcomPHP/shopee-php) to your own GitHub account.
2. **Clone Locally:** 

```bash
git clone https://github.com/your-username/shopee-php.git
cd shopee-php
```

3. **Create a Feature Branch:** Use a descriptive name for your branch.

```bash
git checkout -b feature/add-logistics-endpoints
# or
git checkout -b fix/auth-token-refresh
```

4. **Install Dependencies:** Run `composer install` to set up the development environment.
5. **Write Code & Tests:** Make your modifications. If you're adding new API capabilities, please include corresponding unit tests if applicable.
6. **Commit Changes:** Write clear, concise, and descriptive commit messages.

```bash
git commit -m "feat(product): add support for v2.product.update_stock endpoint"
```

7. **Push & Open PR:** Push your branch to your fork and submit a Pull Request against the `master` (or default development) branch of the main repository.

---

## 📐 Coding Standards & Guidelines

To maintain code quality and readability, please ensure your contributions adhere to the following rules:

* **PHP Coding Standards:** Your code must follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding style standards.
* **Strict Typing:** Always use strict types declarations (`declare(strict_types=1);`) where applicable.
* **Clean & Documented:** Keep functions modular, name your variables descriptively, and comment on complex logic blocks.
* **Shopee Documentation:** When adding or wrapping new Shopee endpoints, link the official Shopee Open Platform documentation reference inside your code comments or PR description for easier review.

---

## ⚖️ License & Developer Certificate of Origin

By contributing to **EcomPHP Shopee PHP SDK**, you agree that your contributions will be licensed under the project's [Apache License 2.0](https://www.google.com/search?q=LICENSE).

You also certify that you wrote the code yourself or have the legal right to submit it as open-source material.
