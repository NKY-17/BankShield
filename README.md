# BankShield 🏦
### An Explainable, Rule-Based Financial Fraud Detection and Banking Management Platform

## Overview

BankShield is a banking management and fraud protection platform designed to support secure banking operations and make suspicious financial activities easier to identify and investigate.

The platform combines essential banking services with an explainable, rule-based fraud detection system. Instead of relying on machine learning or black-box algorithms, BankShield uses configurable rules and weighted risk scoring to identify unusual transaction patterns and provide understandable reasons behind each alert.

The system aims to help banking staff monitor transactions, prioritize suspicious activities, manage customer accounts, and investigate potential fraud through a centralized platform.

## Project Objectives

- Provide a centralized platform for essential banking operations.
- Support secure and convenient financial transactions.
- Identify suspicious transaction patterns using configurable rules.
- Explain why a transaction is flagged as suspicious.
- Help staff prioritize and investigate potential fraud cases.
- Provide useful insights through dashboards and transaction analytics.
- Maintain records of important actions for transparency and accountability.

## Core Modules

### 1. Payments

The Payments module focuses on convenient and secure financial transactions.

Planned capabilities include:
- Money transfers with OTP verification.
- QR code payments.
- Bill payments and mobile recharge.
- Saved receivers for frequently used recipients.
- Scheduled transfers.

### 2. Accounts & Loans

The Accounts & Loans module manages customer accounts and banking-related services.

Planned capabilities include:
- Online account opening with video KYC.
- Loan applications and approval workflows.
- EMI schedule generation.
- Branch and ATM location services.
- Customer and account management.
- Fixed deposit services.

### 3. Fraud Protection

The Fraud Protection module focuses on identifying, monitoring, and investigating potentially suspicious financial activities.

Planned capabilities include:
- Rule-based fraud detection and transaction verification.
- Fraud case management through an investigation board.
- Notifications for suspicious activities.
- Configurable fraud limits.
- Card management.

The fraud detection approach uses:
- Configurable transaction rules.
- Weighted risk scoring.
- Risk-level classification.
- Explanations of triggered rules.
- Prioritized suspicious transaction alerts.
- Investigation records and case tracking.
- What-If analysis to evaluate different rules and thresholds.

A suspicious transaction is treated as an alert for investigation, not automatic proof of fraud.

### 4. Support & Insights

The Support & Insights module aims to improve customer support and provide useful financial information.

Planned capabilities include:
- Live customer support chat.
- Spending analytics.
- Banking administration dashboard.
- Transaction history and statements.
- Transaction dispute management.

## Fraud Detection Approach

BankShield follows an explainable, rule-based approach rather than machine learning.

The system evaluates transaction information using configurable conditions, such as:

- Unusually large transaction amounts.
- High transaction frequency within a short period.
- Repeated transactions.
- Unusual transaction patterns based on available history.

Each triggered rule contributes to a weighted risk score. Based on the resulting score, transactions can be categorized into different risk levels and prioritized for further investigation.

This approach makes the detection process understandable because staff can see which rules were triggered and how they contributed to the risk score.

## Investigation Workflow

The proposed fraud investigation process includes:

1. Transaction data is imported and validated.
2. Configured rules are applied to transactions.
3. Triggered rules contribute to a weighted risk score.
4. Transactions are categorized according to their risk levels.
5. Suspicious transactions appear in a prioritized investigation queue.
6. Staff review related transactions and investigate potential cases.
7. Investigation notes, statuses, and outcomes are recorded.
8. Historical records support auditing and further analysis.

## Technology Stack

| Area | Technology |
|---|---|
| Backend | PHP, Laravel |
| Frontend | HTML, CSS, JavaScript, Blade |
| Database | MySQL |
| Architecture | Model-View-Controller (MVC) |
| Version Control | Git and GitHub |
| Data Visualization | JavaScript charting library |

## Data & Evaluation

The project may use publicly available financial transaction datasets and clearly identified synthetic transaction data for demonstration and evaluation.

Potential dataset sources include:
- Credit Card Fraud Detection dataset.
- PaySim mobile money transaction dataset.

Evaluation may consider detection performance, false alerts, risk-score behavior, rule effectiveness, and investigation workload, depending on the availability and quality of labelled data.

## Security & Responsible Use

BankShield is an academic project and demonstration platform. It is not connected to real banking infrastructure and is not intended to process real customer financial transactions.

The fraud detection component is designed as a decision-support system. Its alerts indicate potentially suspicious activity and require human review before any conclusion is made.

## Development Team

- **Nujahir Kamal Yusha** — Accounts & Loans
- **Wahid Al Amin** — Payments
- **Samiya Khan** — Fraud Protection
- **Tanzim Sajid** — Support & Insights

## Project Information

**Institution:** BRAC University  
**Department:** Computer Science and Engineering (CSE)  
**Project Name:** BankShield

---

*BankShield aims to combine essential banking services with transparent and explainable fraud monitoring to support safer and more accountable banking operations.*