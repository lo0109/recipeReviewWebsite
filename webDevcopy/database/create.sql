drop table if exists recipe;
drop table if exists category;
drop table if exists comments;
drop table if exists users;


-- Create user table
CREATE TABLE users (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    user_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
);

-- Create comment table
CREATE TABLE comments (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    recipe_id INTEGER NOT NULL,
    user_id smallint NOT NULL,
    comment TEXT NOT NULL,
    rating TINYINT(1) NOT NULL,
    c_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipe_id) REFERENCES recipe(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create category table
create table category (
    id integer not null primary key autoincrement,
    category varchar(80) not null,
    rating DECIMAL(2,1) default NULL,
    item_count smallint default 0
);

-- Insert sample categories
insert into category values (null, 'Pasta', null,0);   
insert into category values (null, 'Salad', null,0);
insert into category values (null, 'Soup', null,0);
insert into category values (null, 'Risotto', null,0);
insert into category values (null, 'Dessert', null,0);
insert into category values (null, 'Breakfast', null,0);
insert into category values (null, 'Snack', null,0);
insert into category values (null, 'Other', null,0);

-- Create recipe table with foreign key referencing category
create table recipe (    
    id integer not null primary key autoincrement,  
    recipe varchar(80) not null,  
    summary TEXT not null,    
    ingredients TEXT not null,
    instructions TEXT not null,
    preparation_time SMALLINT not null,
    cook_time SMALLINT not null,
    total_time SMALLINT not null,
    rating DECIMAL(2,1) default NULL,
    img varchar(10),
    calories SMALLINT not null,
    category_id TINYINT(1) not null,
    bookmark TINYINT(1) default 0,
    user_id integer default NULL,
    update_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    review smallint default 0,
    foreign key (user_id) references users(id),
    foreign key (category_id) references category(id)
);

-- Insert a sample recipe
insert into recipe values (
    null, 
    'Creamy mushroom pasta', 
    'This creamy mushroom pasta makes a healthy, super-satisfying dinner for two at just over £1 per portion. Dr Rupy uses silken tofu to give the sauce a wonderful creaminess and extra protein. Each serving provides 743 kcal, 28g protein, 53g carbohydrate (of which 7g sugars), 14g fat (of which 2g saturates), 12g fibre and 1.2g salt.',
    '150g/5½oz wholewheat tagliatelle (or spaghetti); olive oil, for frying; 1 large leek, thinly sliced; 200g/7oz baby leaf spinach (or frozen spinach, see Recipe Tip); 200g/7oz mushrooms, thickly sliced; 2 garlic cloves, crushed; 150g/5½oz silken tofu; 1 tbsp light soy sauce; salt and freshly ground black pepper',
    'Cook the pasta in a large saucepan of boiling salted water for 10 minutes, or according to the packet instructions. Drain the pasta, reserving some of the cooking water.; Meanwhile, heat a splash of olive oil in a large frying pan over a medium heat and fry the leeks gently for 5 minutes, until soft. Spoon into a bowl and set aside.; Add a little more oil to the pan, increase the heat, then add the spinach and cook for a minute or 2, until wilted. Tip the spinach out onto a plate lined with kitchen paper, cover with more kitchen paper and squeeze out the excess moisture.; Heat some more oil in the frying pan, add the mushrooms and fry over a high heat until softened and caramelised. Add the garlic, fry for a couple of minutes, then return the leeks and spinach to the pan.; Put the silken tofu and soy sauce in a tall jug and add 3 tablespoons of the reserved pasta water. Use a stick blender to blend to a smooth sauce, then pour into the pan with the mushroom mixture.; Add the cooked pasta to the pan and toss everything together. Season to taste with salt and pepper, then serve.',
    30, 
    30,
    60,
    NULL,  -- No rating provided yet, so NULL is used
    'img/1.jpg', 
    743,
    1, -- Pasta category
    1,
    null,
    null,
    0
);
insert into recipe values (
    null, 
    'Meatballs with fennel & balsamic beans & courgette noodles', 
    "Rich in potassium, we've swapped pasta for courgettes to make ultra-trendy courgetti. Potassium helps to lower blood pressure and maintain a healthy heart rate    '150g/5½oz wholewheat tagliatelle (or spaghetti); olive oil, for frying; 1 large leek, thinly sliced; 200g/7oz baby leaf spinach (or frozen spinach, see Recipe Tip); 200g/7oz mushrooms, thickly sliced; 2 garlic cloves, crushed; 150g/5½oz silken tofu; 1 tbsp light soy sauce; salt and freshly ground black pepper",
    '400g lean beef steak mince;2 tsp dried oregano;1 large egg;8 garlic cloves, 1 finely grated, the other sliced;1-2 tbsp olive oil;1 fennel bulb, finely chopped, fronds reserved;2 carrots, finely chopped;500g carton passata;4 tbsp balsamic vinegar;600ml reduced-salt vegetable bouillon',
    "Put the mince, oregano, egg and grated garlic in a bowl and grind in some black pepper. Mix together thoroughly and roll into 16 balls.;Heat the oil in a large sauté pan over a medium-high heat, add the meatballs and fry, moving them around the pan so that they brown all over – be careful as they’re quite delicate and you don’t want them to break up. Once brown, remove them from the pan. Reduce the heat slightly and add the fennel, carrots and sliced garlic to the pan and fry, stirring until they soften, about 5 mins.;Tip in the passata, balsamic vinegar and bouillon, stir well, then return the meatballs to the pan, cover and cook gently for 20-25 mins.;Meanwhile, heat the 1 tsp of oil in a non-stick pan and stir-fry the courgette with the beans to heat through and soften. Serve with the meatballs and scatter with any fennel fronds.",
    35, 
    40, 
    75,
    NULL,  -- No rating provided yet, so NULL is used
    'img/2.jpg', 
    743,
    1,
    0,
    null,
    null,
    0
);
insert into recipe values (
    null, 
    'Bean & feta spread with Greek salad salsa & oatcakes', 
    "Tuck into a nutrient-packed vegetarian lunch featuring a delicious bean and feta spread and a salsa that makes up three of your five-a-day. Pile those oatcakes high!",
    '400g can butter beans, drained;1 lemon, ½ juiced, ½ cut into 4 wedges;2 tbsp ricotta or bio yogurt;85g feta, crumbled;1 garlic clove;12 oatcakes;4 tomatoes, chopped;1 medium cucumber, finely diced;1 small red onion, finely chopped;12 pitted Kalamata olives, chopped;a few chopped mint leaves (optional)',
    'Tip the beans, lemon juice, ricotta, 50g feta and the garlic into a bowl and blitz with a hand blender or in a food processor to make a paste. Stir in the remaining feta and spoon the mixture into four small pots.;To make the salsa, stir all the ingredients together with the mint (if using) and divide into four more pots, topping with a lemon wedge. These will keep, chilled in an airtight container, for two-three days. To eat, spread the oatcakes with the bean mixture, squeeze the lemon wedges over the salads and pile generously onto the oatcakes.',
    10, 
    0, 
    10,
    NULL,  -- No rating provided yet, so NULL is used
    'img/3.jpg', 
    382,
    2, -- Salad category
    0,
    null,
    null,
    0
);
insert into recipe values (
    null, 
    'Mexican bean soup with guacamole', 
    "This warming, spiced vegetarian soup packs in goodness and is filling too. The quick-to-assemble guacamole topping tastes as good as it looks",
    '2 tsp rapeseed oil;1 large onion, finely chopped;1 red pepper, cut into chunks;2 garlic cloves, chopped;2 tsp mild chilli powder;1 tsp ground coriander;1 tsp ground cumin;400g can chopped tomatoes;400g can black beans;1 tsp vegetable bouillon powder;1 small avocado;handful chopped coriander;1 lime, juiced;½ red chilli, deseeded and finely chopped (optional)',
    'Heat the oil in a medium pan, add the onion (reserving 1 tbsp to make the guacamole later) and pepper and fry, stirring frequently, for 10 mins. Stir in the garlic and spices, then tip in the tomatoes and beans with their liquid, half a can of water and the bouillon powder. Simmer, covered, for 15 mins.;Meanwhile, peel and de-stone the avocado and tip into a bowl, add the remaining onion, coriander and lime juice with a little chilli (if using) and mash well. Ladle the soup into two bowls, top with the guacamole and serve.',
    10, 
    20, 
    30,
    NULL,  -- No rating provided yet, so NULL is used
    'img/4.jpg', 
    391,
    3, -- Soup category
    0,
    null,
    null,
    0
);
insert into recipe values (
    null, 
    'Poached eggs with smashed avocado & tomatoes', 
    "Keep yourself full until lunchtime with this healthy breakfast boost. Delicious avocado serves as a butter alternative and goes well with a runny poached egg",
    '2 tomatoes, halved;½ tsp rapeseed oil;2 eggs;1 small ripe avocado;2 slices seeded wholemeal soda bread (see goes well with);2 handfuls rocket',
    'Heat a non-stick frying pan, very lightly brush the cut surface of the tomatoes with a little oil, then cook them, cut-side down, in the pan until they have softened and slightly caramelised. Meanwhile, heat a pan of water, carefully break in the eggs and leave to poach for 1-2 mins until the whites are firm but the yolks are still runny.;Halve and stone the avocado, then scoop out the flesh and smash onto the bread. Add the eggs, grind over black pepper and add a handful of rocket to each portion. Serve the tomatoes on the side.',
    10, 
    10,
    20, 
    NULL,  -- No rating provided yet, so NULL is used
    'img/5.jpg', 
    385,
    6, -- Breakfast category
    0,
    null,
    null,
    0
);
insert into recipe values (
    null, 
    'Prawn, fennel & rocket risotto', 
    "This prawn and fennel risotto gets a little extra kick from lemon zest and and rocket - perfect for a dinner party",
    '1.2l vegetable stock;1 tbsp olive oil;1 onion, finely chopped;1 large garlic clove, finely chopped;1 small fennel bulb, cored and finely chopped;300g risotto rice;300g peeled raw king prawns;1 lemon, 0.5 zested and 1 tbsp juice;70g bag rocket',
    'Put the stock in a large saucepan, bring to the boil, then lower to a simmer. Meanwhile, heat the oil in a large saucepan. Add the onion, garlic and fennel, and cook on a low heat for 10 mins until the vegetables have softened but not coloured. Add the rice and stir for 2 mins until the grains are hot and making crackling sounds. Increase the heat to medium and start adding the stock, a ladleful at a time, stirring constantly and making sure the stock has absorbed into the rice before adding the next ladleful.;When the rice is almost cooked, add the prawns, lemon zest and some seasoning. Continue adding stock and cooking for another 3-4 mins until the prawns are pink and the rice is cooked. Remove from the heat and stir through the rocket and lemon juice. Check the seasoning, leave the risotto to sit in the pan for 2 mins, then serve.',
    15, 
    35, 
    50,
    NULL,  -- No rating provided yet, so NULL is used
    'img/6.jpg', 
    391,
    4, -- Risotto category
    0,
    null,
    null,
    0
);

Update category set item_count = (select count(*) from recipe where category_id = category.id);