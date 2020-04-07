/** @typedef {{name: string, version: string, description: string, main: string, repository: string, author: string, license: string}} pkg */
const write = require('fs').writeFileSync;
const path = require('path').resolve;

let res = '/*\n';
res += `Theme Name: Nostra Sponte\n`;
if (process.env.npm_package_repository_type === 'git') res += `Theme URI: ${process.env.npm_package_repository_url.replace(/^git@(.*):(.*).git$/, 'https://$1/$2')}\n`;
res += `Author: ${process.env.npm_package_author_name}\n`;
if (process.env.npm_package_author_email) res += `Author URI: mailto:${process.env.npm_package_author_email}\n`;
res += `Description: ${process.env.npm_package_description}\n`;
res += `Version: ${process.env.npm_package_version}\n`;
res += `License: GNU General Public License 3.0 or later\n`;
res += `License URI: http://www.gnu.org/licenses/gpl-3.0\n`;
res += `Text Domain: nostrasponte\n`;
res += '*/';

write(path(__dirname, '../../../style.css'), res);