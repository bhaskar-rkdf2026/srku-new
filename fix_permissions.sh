#!/bin/bash
# ==============================================================
# SRKU University Web Application - Hardened Permissions Enforcer
# Run on Linux/cPanel/VPS: bash fix_permissions.sh
# ==============================================================

TARGET_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
echo "Enforcing secure permissions on: $TARGET_DIR"

# 1. Set all directories to 755 (drwxr-xr-x)
# Owner can read, write, execute. Group & others cannot write/tamper.
find "$TARGET_DIR" -type d -exec chmod 755 {} +
echo "[OK] All directories set to 755 (rwxr-xr-x)"

# 2. Set all regular files to 644 (-rw-r--r--)
# Owner can read and write. Group & others can only read. No execution!
find "$TARGET_DIR" -type f -exec chmod 644 {} +
echo "[OK] All files set to 644 (rw-r--r--)"

# 3. Restrict high-security configuration files to 600 (-rw-------)
# Only web server owner can read credentials
for secfile in config/config.php config/db.php .env; do
    if [ -f "$TARGET_DIR/$secfile" ]; then
        chmod 600 "$TARGET_DIR/$secfile"
        echo "[OK] Locked $secfile to 600"
    fi
done

# 4. Restrict all SQL database dumps to 600
find "$TARGET_DIR" -maxdepth 1 -name "*.sql" -exec chmod 600 {} + 2>/dev/null
echo "[OK] SQL database dumps locked"

# 5. Make this script executable for future runs
chmod +x "$TARGET_DIR/fix_permissions.sh"

echo "=============================================================="
echo "SUCCESS: Project file & folder permissions hardened securely!"
echo "=============================================================="
