# 🏦 BankShield
### Banking Management and Fraud Protection System

BankShield is a web-based banking management and fraud protection platform designed to support secure, efficient, and transparent banking operations. The system brings together essential banking services, account management, payment processing, customer support, financial insights, and explainable rule-based fraud detection in one centralized application.

Developed as an academic group project at **BRAC University**, BankShield aims to demonstrate how modern web technologies and transparent detection mechanisms can contribute to more organized and secure banking operations.

---

## 📌 Project Overview

BankShield focuses on four major areas:

- **Payments:** Secure money transfers, bill payments, mobile recharge, and payment management.
- **Accounts & Loans:** Customer accounts, loan applications, fixed deposits, and banking services.
- **Fraud Protection:** Explainable rule-based transaction monitoring, suspicious activity detection, and investigation management.
- **Support & Insights:** Customer support, spending analytics, transaction history, and administrative dashboards.

The platform is designed to combine everyday banking functionalities with security-focused features and financial monitoring tools.

## ✨ Key Features

The project consists of 20 planned features distributed across four modules.

### 1. Payments

- **Money Transfer with OTP:** Transfer money between BankShield accounts with additional email OTP verification for large transactions.
- **QR Code Payment:** Enable customers to make payments by scanning merchant-generated QR codes.
- **Bill Payment & Mobile Recharge:** Support utility bill payments and mobile recharges with transaction receipts.
- **Saved Receivers:** Save, edit, and remove frequently used recipients.
- **Scheduled Transfers:** Schedule future or recurring transfers and manage payment schedules.

### 2. Accounts & Loans

- **Online Account Opening with Video KYC:** Allow customers to apply for accounts online and complete identity verification through a video verification process.
- **Loan Application & Approval:** Submit loan applications, review supporting documents, approve or reject applications, and generate EMI repayment schedules.
- **Branch & ATM Map:** Display nearby bank branches and ATMs with location information and directions.
- **Customer & Account Management:** Allow authorized staff to create, view, search, and update customer profiles and manage savings and current accounts.
- **Fixed Deposits:** Allow customers to open fixed deposits for different durations and view expected interest earnings.

### 3. Fraud Protection

- **Fraud Detection & "Was This You?":** Identify potentially suspicious transactions using unusual transaction amounts, frequency, login activity, and behavioral patterns.
- **Fraud Case Board:** Provide a case management board for reviewing flagged transactions, recording investigation notes, and tracking investigation progress.
- **Live Notifications:** Notify customers about transactions, new-device logins, and suspicious account activities.
- **Fraud Limit Settings:** Allow administrators to configure transaction thresholds and behavioral limits.
- **Card Management:** Allow customers to view virtual debit cards, freeze or unfreeze cards, and configure spending limits.

### 4. Support & Insights

- **Live Support Chat:** Connect customers with support agents through a real-time messaging system.
- **Spending Analytics:** Display interactive financial charts showing spending patterns, received money, and monthly comparisons.
- **Bank Admin Dashboard:** Present bank-wide statistics and visual summaries of transactions, accounts, loans, and reported fraud cases.
- **Transaction History & Statements:** Search, filter, and download transaction statements.
- **Transaction Disputes:** Allow customers to report disputed transactions and track investigation outcomes.

---

## 🔍 Explainable Rule-Based Fraud Detection

A central focus of BankShield is its explainable, rule-based financial fraud detection and investigation approach.

Instead of relying on Machine Learning models or black-box predictions, the proposed detection engine uses configurable conditions, transaction-pattern analysis, and weighted risk scoring.

### How It Works

1. **Transaction Import:** Authorized users import transaction records using supported CSV files.
2. **Rule Evaluation:** The system checks transactions against configurable suspicious-activity rules.
3. **Risk Scoring:** Each triggered rule contributes predefined risk points to the transaction.
4. **Alert Prioritization:** Transactions are categorized according to their calculated risk scores and organized into an investigation queue.
5. **Explainable Results:** Each alert displays the triggered rules and explains how its risk score was calculated.
6. **Case Investigation:** Authorized reviewers examine suspicious activity, record findings, and update investigation statuses.
7. **Performance Evaluation:** Alternative detection configurations can be compared using labelled transaction data and appropriate evaluation metrics.

### Key Detection Capabilities

- Unusually large transactions.
- Multiple transactions within a short period.
- Repeated transaction patterns.
- Combinations of suspicious transaction conditions.
- Configurable risk weights and alert thresholds.
- Prioritized investigation queues.
- Related-transaction analysis.

### What-If Analysis & Investigation Capacity Evaluation

BankShield also aims to provide a configurable analysis module that allows administrators to compare detection rules, risk weights, and alert thresholds.

The module will help evaluate:

- Detection coverage.
- False-alert rates.
- Alert volume.
- Risk-score distributions.
- Investigation workload.
- Detection performance under limited investigation capacity.

The evaluation will use suitable labelled public datasets and clearly identified synthetic demonstration records.

**Core Principle:** Every alert should have an understandable explanation, every investigation should be traceable, and every detection configuration should be measurable.

---

## 🛠️ Technology Stack

| Technology | Purpose |
|---|---|
| PHP | Backend programming |
| Laravel | Web application framework |
| MySQL | Database management |
| Blade | Server-side templating |
| HTML | Page structure |
| CSS | Interface styling |
| JavaScript | Frontend interactions and charts |
| Git & GitHub | Version control and collaboration |

**Architecture:** Model–View–Controller (MVC)

**Fraud Detection Approach:** Configurable rules, conditional logic, database queries, and weighted risk scoring.

The fraud detection component is designed without Machine Learning models, neural networks, generative AI, or external AI APIs.

---

## 👥 Team Members & Responsibilities

The project is divided into four modules, with each team member responsible for a specific area.

| Team Member | Module | Feature Range |
|---|---|---|
| Wahid Al Amin | Payments | 1–5 |
| Nujahir Kamal Yusha | Accounts & Loans | 6–10 |
| Samiya Khan | Fraud Protection | 11–15 |
| Tanzim Sajid | Support & Insights | 16–20 |

---

## 🎯 Project Objectives

- Develop a centralized web-based banking management platform.
- Simplify customer and account management.
- Support secure and convenient payment operations.
- Provide accessible banking and loan-related services.
- Identify potentially suspicious financial activity through transparent detection rules.
- Improve alert prioritization and investigation workflows.
- Provide meaningful financial analytics and administrative insights.
- Maintain accountability through authentication, authorization, and audit records.

## 🔐 Security & Responsible Use

BankShield emphasizes secure application development and responsible fraud detection.

The system aims to incorporate:

- Authentication and role-based access control.
- Input validation and secure data handling.
- Protected administrative operations.
- Traceable investigation activities.
- Configurable detection rules and thresholds.
- Clear explanations for suspicious-activity alerts.

BankShield is a demonstration and decision-support platform. It does not connect to real banking infrastructure, process real customer transactions, or independently establish that fraud has occurred.

Public datasets and clearly identified synthetic records are intended for development, demonstration, and evaluation.

---

## 📊 Expected Outcome

The expected outcome is an integrated banking management and fraud protection application that combines everyday banking services with transparent transaction monitoring and investigation capabilities.

BankShield aims to demonstrate how banking operations, explainable fraud detection, structured investigations, and financial insights can be brought together in a single web-based platform.

---

## 🎓 Project Information

- **Project Name:** BankShield
- **Project Type:** Academic Group Project
- **Department:** Computer Science and Engineering
- **University:** BRAC University

---

*Developed for academic purposes.*