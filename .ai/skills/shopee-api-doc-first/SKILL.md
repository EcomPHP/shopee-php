---
name: shopee-api-doc-first
description: For any Shopee API related task, look up API documentation first via the Shopee MCP server before analyzing or implementing changes.
---

# Shopee API Doc-First Skill

Use this skill whenever the task touches Shopee API behavior, endpoint names, request parameters, response fields, auth flow, or SDK resource/API mapping.

## Mandatory workflow

1. **Lookup first via MCP**
   - Before proposing code changes, answering API questions, or implementing integrations, call the Shopee MCP documentation search tool first:
   - `mcp_shopee_search_documents`
   - Query by exact API name first when available (example: `v2.order.get_order_list`), then by keywords if needed.

2. **Ground decisions in docs**
   - Use the documentation lookup result as the source of truth for:
     - endpoint/API names
     - required and optional request parameters
     - response field expectations
     - related Shopee resource/module

3. **Then implement or answer**
   - Only after documentation lookup, proceed to explanation, code changes, or tests.
   - If docs are missing or unclear, explicitly state that limitation and use the closest verified SDK reference.

## Practical checklist

- [ ] Shopee MCP docs search was executed before implementation/analysis.
- [ ] Exact API name was used in query when known.
- [ ] Final answer/change aligns with documented request/response structure.
- [ ] Any documentation gaps are called out explicitly.